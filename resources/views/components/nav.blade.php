<nav class="bg-slate-900 text-white px-4 h-14 flex items-stretch">
    
    <span class="font-bold text-lg flex items-center mr-4">Simple POS</span>

    <a href="{{ route('pos.create') }}" 
       class="flex items-center px-4 transition {{ request()->routeIs('pos.*') ? 
       'bg-slate-800 text-white font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
        Kasir
    </a>

    <a href="{{ route('transactions.index') }}" 
       class="flex items-center px-4 transition {{ request()->routeIs('transactions.*') ? 
       'bg-slate-800 text-white font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
        Transaksi
    </a>
</nav>