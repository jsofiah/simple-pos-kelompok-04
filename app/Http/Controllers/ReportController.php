<?php

namespace App\Http\Controllers;

use App\Exports\SalesReportExport;
use App\Jobs\ProcessProductImport;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\ImportError;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Imports\ProductsImport;


class ReportController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to, $categoryId] = $this->resolveFilters($request);
        $query = $this->filteredQuery($from, $to, $categoryId);

        return view('reports.index', [
            'totalPenjualan'  => $query->sum('total'),
            'jumlahTransaksi' => $query->count(),
            'from'            => $from->toDateString(),
            'to'              => $to->toDateString(),
            'categoryId'      => $categoryId,
            'categories'      => Category::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        [$from, $to, $categoryId] = $this->resolveFilters($request);
        $query = $this->filteredQuery($from, $to, $categoryId);

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Tanggal', 'Kasir', 'Total']);
            foreach ($query->lazyById() as $t) {
                fputcsv($out, [$t->id, $t->created_at, $t->user->name, $t->total]);
            }
            fclose($out);
        }, 'laporan-penjualan.csv');
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        [$from, $to, $categoryId] = $this->resolveFilters($request);
        return Excel::download(
            new SalesReportExport($this->filteredQuery($from, $to, $categoryId)),
            'laporan-penjualan.xlsx',
        );
    }

    public function exportPdf(Request $request): Response
    {
        [$from, $to, $categoryId] = $this->resolveFilters($request);

        $pdf = Pdf::loadView('reports.pdf', [
            'totalPenjualan'  => $this->filteredQuery($from, $to, $categoryId)->sum('total'),
            'jumlahTransaksi' => $this->filteredQuery($from, $to, $categoryId)->count(),
            'transactions'    => $this->filteredQuery($from, $to, $categoryId)->latest()->limit(50)->get(),
            'from'            => $from->toDateString(),
            'to'              => $to->toDateString(),
            'categoryName'    => $categoryId ? Category::find($categoryId)?->name : null,
        ]);
        return $pdf->download('laporan-penjualan.pdf');
    }

    public function importForm(): View
    {
        $importErrors = ImportError::latest()->take(10)->get();
        return view('reports.import', compact('importErrors'));
    }
    public function clearErrors(): RedirectResponse
    {
        ImportError::truncate();
        return back()->with('success', 'Log error berhasil dibersihkan.');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt'],
        ]);
        $path = $request->file('csv')->store('imports');
        ProcessProductImport::dispatch($path);
        return back()->with('success', 'Import sedang diproses di background.');
    }

        public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $import = new ProductsImport;
        Excel::import($import, $request->file('csv'));

        return back()->with('success', "Import selesai, {$import->failures()->count()} row dilewati.");
    }

    private function resolveFilters(Request $request): array
    {
        $from = $request->date('from')?->startOfDay() ?? now()->startOfMonth();
        $to   = $request->date('to')?->endOfDay()     ?? now()->endOfDay();
        $categoryId = $request->integer('category_id') ?: null;

        return [$from, $to, $categoryId];
    }

    private function filteredQuery($from, $to, ?int $categoryId = null): Builder
    {
        return Transaction::with('user')
            ->whereBetween('created_at', [$from, $to])
            ->when($categoryId, function (Builder $q) use ($categoryId) {
                $q->whereHas('details.product', function (Builder $q2) use ($categoryId) {
                    $q2->where('category_id', $categoryId);
                });
            });
    }
}