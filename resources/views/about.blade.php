<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tentang — {{ config('app.name', 'Simple POS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;--color-slate-50:#f8fafc;--color-slate-100:#f1f5f9;--color-slate-500:#64748b;--color-slate-600:#475569;--color-slate-900:#0f172a;--color-white:#fff;--color-black:#000;--spacing:.25rem;--radius-sm:.25rem;--radius-lg:.5rem;--radius-xl:.75rem;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--text-xs:.75rem;--text-sm:.875rem;--text-base:1rem;--text-lg:1.125rem;--text-2xl:1.5rem;--default-font-family:var(--font-sans)}}
                @layer base{*,:after,:before{box-sizing:border-box;border:0 solid;margin:0;padding:0}html{line-height:1.5;font-family:var(--default-font-family);-webkit-text-size-adjust:100%}body{line-height:inherit}a{color:inherit;text-decoration:inherit}h1{font-size:inherit;font-weight:inherit}}
                @layer utilities{
                    .min-h-screen{min-height:100vh}
                    .flex{display:flex}
                    .inline-flex{display:inline-flex}
                    .flex-col{flex-direction:column}
                    .items-center{align-items:center}
                    .justify-center{justify-content:center}
                    .justify-between{justify-content:space-between}
                    .gap-2{gap:calc(var(--spacing)*2)}
                    .gap-3{gap:calc(var(--spacing)*3)}
                    .gap-4{gap:calc(var(--spacing)*4)}
                    .mb-1{margin-bottom:calc(var(--spacing)*1)}
                    .mb-2{margin-bottom:calc(var(--spacing)*2)}
                    .mb-4{margin-bottom:calc(var(--spacing)*4)}
                    .mb-6{margin-bottom:calc(var(--spacing)*6)}
                    .mb-8{margin-bottom:calc(var(--spacing)*8)}
                    .mt-2{margin-top:calc(var(--spacing)*2)}
                    .mt-6{margin-top:calc(var(--spacing)*6)}
                    .mt-auto{margin-top:auto}
                    .p-6{padding:calc(var(--spacing)*6)}
                    .p-8{padding:calc(var(--spacing)*8)}
                    .px-5{padding-inline:calc(var(--spacing)*5)}
                    .py-1\.5{padding-block:calc(var(--spacing)*1.5)}
                    .py-2{padding-block:calc(var(--spacing)*2)}
                    .py-12{padding-block:calc(var(--spacing)*12)}
                    .py-16{padding-block:calc(var(--spacing)*16)}
                    .mx-auto{margin-inline:auto}
                    .max-w-2xl{max-width:42rem}
                    .w-full{width:100%}
                    .rounded-sm{border-radius:var(--radius-sm)}
                    .rounded-lg{border-radius:var(--radius-lg)}
                    .rounded-xl{border-radius:var(--radius-xl)}
                    .border{border-style:solid;border-width:1px}
                    .border-transparent{border-color:transparent}
                    .text-xs{font-size:var(--text-xs);line-height:calc(1/.75)}
                    .text-sm{font-size:var(--text-sm);line-height:calc(1.25/.875)}
                    .text-base{font-size:var(--text-base);line-height:1.5}
                    .text-lg{font-size:var(--text-lg);line-height:calc(1.75/1.125)}
                    .text-2xl{font-size:var(--text-2xl);line-height:calc(2/1.5)}
                    .font-medium{font-weight:500}
                    .font-semibold{font-weight:600}
                    .leading-normal{line-height:1.5}
                    .leading-relaxed{line-height:1.625}
                    .text-center{text-align:center}
                    .underline{text-decoration-line:underline}
                    .underline-offset-4{text-underline-offset:4px}
                    .shadow-sm{box-shadow:var(--shadow-sm)}
                    .shadow-lg{box-shadow:var(--shadow-lg)}
                    .bg-white{background-color:var(--color-white)}
                    .text-white{color:var(--color-white)}
                    .text-slate-500{color:var(--color-slate-500)}
                    .text-slate-600{color:var(--color-slate-600)}
                    .text-slate-900{color:var(--color-slate-900)}
                    .bg-slate-100{background-color:var(--color-slate-100)}
                    .bg-slate-900{background-color:var(--color-slate-900)}
                }
                @media (prefers-color-scheme: dark) {
                    .dark\:bg-\[\#0a0a0a\]{background-color:#0a0a0a}
                    .dark\:bg-\[\#161615\]{background-color:#161615}
                    .dark\:text-\[\#EDEDEC\]{color:#ededec}
                    .dark\:text-\[\#A1A09A\]{color:#a1a09a}
                    .dark\:border-\[\#3E3E3A\]{border-color:#3e3e3a}
                    .dark\:bg-\[\#eeeeec\]{background-color:#eeeeec}
                    .dark\:text-\[\#1C1C1A\]{color:#1c1c1a}
                }
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-[#0a0a0a] dark:text-[#EDEDEC] flex flex-col">

        <header class="w-full max-w-2xl mx-auto px-5 py-6 flex items-center justify-between">
            <span class="font-semibold text-lg">Simple POS</span>
            @auth
                <a href="{{ route('pos.create') }}"
                   class="inline-flex items-center px-5 py-1.5 bg-slate-900 dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium leading-normal">
                    Buka Kasir →
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center px-5 py-1.5 border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                    Log in
                </a>
            @endauth
        </header>

        <main class="flex-1 flex items-center justify-center px-5 py-12">
            <div class="w-full max-w-2xl">

                <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg shadow-sm overflow-hidden p-6">
                    <div class="h-1.5 w-full bg-[#F53003] dark:bg-[#FF4433]"></div>

                    <div class="p-8">
                        <p class="text-xs font-medium text-[#F53003] dark:text-[#FF4433] mb-2 leading-normal">
                            TENTANG APLIKASI
                        </p>

                        <h1 class="text-2xl font-semibold text-slate-900 dark:text-[#EDEDEC] mb-4 leading-normal">
                            Simple POS
                        </h1>

                        <p class="text-sm text-slate-600 dark:text-[#A1A09A] leading-relaxed mb-6">
                            Aplikasi <strong>Point of Sale</strong> sederhana yang dibangun dengan
                            <strong>Laravel</strong> untuk keperluan praktikum
                            Pemrograman Web Lanjut di Politeknik Negeri Malang.
                        </p>

                        <p class="text-sm text-slate-600 dark:text-[#A1A09A] leading-relaxed mb-8">
                            Simple POS mendukung dua peran utama: <strong>admin</strong>
                            yang mengelola produk &amp; kategori, serta <strong>kasir</strong>
                            yang memproses transaksi penjualan.
                        </p>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] hover:bg-black dark:hover:bg-white text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium leading-normal transition-all">
                                Masuk ke Aplikasi
                            </a>
                            <a href="https://laravel.com/docs" target="_blank"
                               class="inline-flex items-center gap-2 px-5 py-2 border border-[#19140035] dark:border-[#3E3E3A] hover:border-black dark:hover:border-white rounded-sm text-sm leading-normal transition-all">
                                Dokumentasi Laravel
                                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                                    <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                        <p class="text-xs font-medium text-slate-500 dark:text-[#A1A09A] mb-4 leading-normal uppercase tracking-wide">
                            Yang bisa kamu lakukan
                        </p>
                        <ul class="flex flex-col gap-4">
                            <li class="flex gap-3">
                                <span class="shrink-0 mt-1 flex items-center justify-center w-3.5 h-3.5 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-full">
                                    <span class="w-1.5 h-1.5 bg-[#dbdbd7] dark:bg-[#3E3E3A] rounded-full"></span>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-[#EDEDEC] leading-normal">
                                        Kelola produk &amp; kategori
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-[#A1A09A] leading-normal">
                                        Hanya untuk peran <strong>admin</strong>.
                                    </p>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="shrink-0 mt-1 flex items-center justify-center w-3.5 h-3.5 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-full">
                                    <span class="w-1.5 h-1.5 bg-[#dbdbd7] dark:bg-[#3E3E3A] rounded-full"></span>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-[#EDEDEC] leading-normal">
                                        Proses transaksi penjualan
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-[#A1A09A] leading-normal">
                                        Untuk peran <strong>kasir</strong> dan <strong>admin</strong>.
                                    </p>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="shrink-0 mt-1 flex items-center justify-center w-3.5 h-3.5 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-full">
                                    <span class="w-1.5 h-1.5 bg-[#dbdbd7] dark:bg-[#3E3E3A] rounded-full"></span>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-[#EDEDEC] leading-normal">
                                        Autentikasi &amp; otorisasi berbasis peran
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-[#A1A09A] leading-normal">
                                        Middleware <code>role:admin</code> menjaga halaman sensitif.
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <p class="mt-6 text-xs text-slate-500 dark:text-[#A1A09A] text-center leading-normal">
                    Halaman ini hanya dapat diakses oleh tamu (belum login).
                </p>
            </div>
        </main>

        <footer class="w-full max-w-2xl mx-auto px-5 py-6 text-center text-xs text-slate-500 dark:text-[#A1A09A]">
            &copy; {{ date('Y') }} Simple POS · Praktikum Pemrograman Web Lanjut
        </footer>

    </body>
</html>