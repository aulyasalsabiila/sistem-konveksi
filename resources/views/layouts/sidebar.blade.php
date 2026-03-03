<div class="w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex flex-col shadow-xl">
    {{-- Logo --}}
    <div class="px-6 py-4 border-b border-blue-700/50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm overflow-hidden">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-xl font-bold">Puspita Indah</h1>
                <p class="text-blue-200 text-xs">Sistem Konveksi</p>
            </div>
        </div>
    </div>
    
    {{-- Navigation --}}
    <nav class="flex-1 px-6 py-4 space-y-1 overflow-y-auto overflow-x-hidden">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('dashboard') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-home w-5 text-center {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        
        {{-- Pesanan --}}
        <a href="{{ route('pesanan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('pesanan.*') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-shopping-cart w-5 text-center {{ request()->routeIs('pesanan.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Pesanan</span>
        </a>
        
        {{-- Bahan Baku --}}
        <a href="{{ route('bahan-baku.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('bahan-baku.*') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-box w-5 text-center {{ request()->routeIs('bahan-baku.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Bahan Baku</span>
        </a>
        
        {{-- Produksi --}}
        <a href="{{ route('produksi.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('produksi.*') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-industry w-5 text-center {{ request()->routeIs('produksi.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Produksi</span>
        </a>
        
        {{-- Laporan --}}
        <a href="{{ route('laporan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('laporan.*') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-file-alt w-5 text-center {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Laporan</span>
        </a>
        
        {{-- Customers --}}
        <a href="{{ route('customers.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('customers.*') ? 'bg-blue-700 shadow-lg' : '' }}">
            <i class="fas fa-users w-5 text-center {{ request()->routeIs('customers.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
            <span class="font-medium text-sm">Customers</span>
        </a>

        {{-- Divider for Admin Section --}}
        <div class="pt-1 pb-1">
            <div class="border-t border-blue-700/50"></div>
            <p class="px-4 pt-3 pb-1 text-xs font-semibold text-blue-400 uppercase tracking-wider">Admin</p>
        </div>

        {{-- History --}}
        @if(Auth::user()->isAdmin())
            {{-- Admin: Clickable --}}
            <a href="{{ route('history.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('history.*') ? 'bg-blue-700 shadow-lg' : '' }}">
                <i class="fas fa-history w-5 text-center {{ request()->routeIs('history.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
                <span class="font-medium text-sm">History</span>
            </a>
        @else
            {{-- Staff: Disabled (Visible but not clickable) --}}
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg opacity-40 cursor-not-allowed group">
                <i class="fas fa-history w-5 text-center text-blue-300"></i>
                <span class="font-medium text-sm">History</span>
            </div>
        @endif

        {{-- User Management --}}
        @if(Auth::user()->isAdmin())
            {{-- Admin: Clickable --}}
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all hover:bg-blue-700/50 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-700 shadow-lg' : '' }}">
                <i class="fas fa-user-cog w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-blue-300 group-hover:text-white' }}"></i>
                <span class="font-medium text-sm">User Management</span>
            </a>
        @else
            {{-- Staff: Disabled (Visible but not clickable) --}}
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg opacity-40 cursor-not-allowed group">
                <i class="fas fa-user-cog w-5 text-center text-blue-300"></i>
                <span class="font-medium text-sm">User Management</span>
            </div>
        @endif
    </nav>

    {{-- Footer --}}
    <div class="p-4 border-t border-blue-700/50">
        <div class="bg-blue-800/30 rounded-lg p-3 text-center">
            <p class="text-xs text-blue-300 mb-1">Version 1.0.0</p>
            <p class="text-xs text-blue-400 font-semibold">© 2026 Puspita Indah</p>
        </div>
    </div>
</div> 