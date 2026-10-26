@extends('layouts.app')
@section('title', 'Import Produk')
@section('content')
    <h1 class="text-lg font-semibold mb-4">Import Produk dari CSV</h1>
    @if (session('success'))
        <div class="bg-green-50 text-green-700 p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($importErrors->count() > 0)
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md mb-6 max-w-md">
            <h3 class="font-semibold mb-2">Log Baris Gagal Import (10 Terakhir)</h3>
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($importErrors as $error)
                    <li><strong>Baris {{ $error->row_number }}:</strong> {{ $error->error_message }}</li>
                @endforeach
            </ul>
            <form action="{{ route('import.clear-errors') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Bersihkan Log Error
                </button>
            </form>
        </div>
    @endif
    
    <form method="POST" action="{{ route('import.store') }}" enctype="multipart/form-data" class="max-w-md">
        @csrf
        <label class="block mb-3">
            <span class="text-sm font-medium mb-1 block">File CSV</span>
            
            <div class="border border-slate-300 rounded-md p-3 bg-white mt-1">
                <input type="file" name="csv" accept=".csv" class="block w-full text-sm file:mr-4 file:py-1 file:px-2 file:rounded file:border-0 file:text-sm file:bg-slate-100 file:text-slate-700">
            </div>

            @error('csv')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </label>
        <p class="text-xs text-slate-500 mb-3">Column yang dibutuhkan: <code>name</code>,
            <code>category_id</code>, <code>price</code>.
        </p>
        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-md text-sm">Import</button>
    </form>
@endsection
