<header class="bg-gradient-to-b from-blue-900 to-blue-800 shadow-sm sticky top-0 z-10">
    <div class="flex items-center justify-between px-6 py-4">
        {{-- Page Title --}}
        <div>
            <h2 class="text-xl font-bold text-white">@yield('page-title', 'Dashboard')</h2>
            <p class="text-xs text-blue-300">@yield('page-subtitle', 'Selamat datang di sistem konveksi')</p>
        </div>
        
        {{-- Right Side --}}
        <div class="flex items-center gap-3">

            {{-- Role Badge --}}
            @if(Auth::user()->isAdmin())
            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold flex items-center gap-1.5">
                Admin
            </span>
            @else
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold flex items-center gap-1.5">
                Staff
            </span>
            @endif

            {{-- Notification Bell --}}
            <div class="relative" x-data="{ openNotif: false }">
                <button @click="openNotif = !openNotif" 
                        class="relative p-2 text-white hover:bg-blue-700/50 rounded-lg transition-all">
                    <i class="fas fa-bell text-lg"></i>
                    @php
                        $stokMenurunCount = \App\Models\BahanBaku::whereColumn('stok', '<', 'minimum_stok')->where('stok', '>', 0)->count();
                        $deadlineMendekatiCount = \App\Models\Pesanan::whereIn('status', ['Pending', 'Dikonfirmasi', 'Proses Produksi'])
                            ->whereRaw('DATEDIFF(deadline, NOW()) <= 3')
                            ->count();
                        $totalNotifications = $stokMenurunCount + $deadlineMendekatiCount;
                    @endphp
                    @if($totalNotifications > 0)
                    <span class="absolute -top-0.5 -right-0.5 min-w-[20px] h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center px-1.5 font-bold shadow-lg">
                        {{ $totalNotifications > 99 ? '99+' : $totalNotifications }}
                    </span>
                    @endif
                </button>

                {{-- Notification Dropdown --}}
                <div x-show="openNotif"
                     @click.away="openNotif = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-xl border border-gray-200 z-54 max-h-[500px] overflow-hidden"
                     style="display: none;">
                    
                    {{-- Notification Header --}}
                    <div class="px-3 py-2 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bell text-blue-600 text-base"></i>
                                </div>
                                Notifikasi
                            </h3>
                            <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded-full font-semibold shadow-sm">
                                {{ $totalNotifications }}
                            </span>
                        </div>
                    </div>

                    {{-- Notification List --}}
                    <div class="overflow-y-auto max-h-[410px]">
                        @if($totalNotifications > 0)
                            {{-- Stok Menipis --}}
                            @php
                                $stokMenurun = \App\Models\BahanBaku::whereColumn('stok', '<', 'minimum_stok')
                                    ->where('stok', '>', 0)
                                    ->orderBy('stok', 'asc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @if($stokMenurun->count() > 0)
                                <div class="border-b border-gray-100">
                                    <div class="px-5 py-2 bg-gray-50">
                                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok Bahan Baku</p>
                                    </div>
                                    @foreach($stokMenurun as $bahan)
                                    <a href="{{ route('bahan-baku.show', $bahan->id) }}" 
                                       class="block px-5 py-2 hover:bg-red-50 transition-all border-b border-gray-50">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-box-open text-red-600"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-gray-800 text-xs truncate">{{ $bahan->nama_bahan }}</p>
                                                <p class="text-xs text-gray-600 mt-1">
                                                    Stok tersisa: <span class="font-bold text-red-600">{{ $bahan->stok }} {{ $bahan->satuan }}</span>
                                                </p>
                                                <p class="text-xs text-gray-500">Minimum: {{ $bahan->minimum_stok }} {{ $bahan->satuan }}</p>
                                            </div>
                                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-md font-medium whitespace-nowrap">
                                                Menipis
                                            </span>
                                        </div>
                                    </a>
                                    @endforeach
                                    
                                    @if($stokMenurunCount > 5)
                                    <a href="{{ route('bahan-baku.index') }}" 
                                       class="block px-5 py-3 text-center text-xs text-blue-600 hover:bg-blue-50 font-semibold transition-all">
                                        Lihat {{ $stokMenurunCount - 5 }} notifikasi lainnya →
                                    </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Deadline Mendekat --}}
                            @php
                                $deadlineMendekat = \App\Models\Pesanan::whereIn('status', ['Pending', 'Dikonfirmasi', 'Proses Produksi'])
                                    ->whereRaw('DATEDIFF(deadline, NOW()) <= 3')
                                    ->orderBy('deadline', 'asc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @if($deadlineMendekat->count() > 0)
                                <div>
                                    <div class="px-5 py-2 bg-gray-50">
                                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Deadline Pesanan</p>
                                    </div>
                                    @foreach($deadlineMendekat as $pesanan)
                                    @php
                                        $deadline = \Carbon\Carbon::parse($pesanan->deadline);
                                        $daysLeft = (int) $deadline->diffInDays(now());
                                    @endphp
                                    <a href="{{ route('pesanan.show', $pesanan->id) }}" 
                                       class="block px-5 py-2 hover:bg-orange-50 transition-all border-b border-gray-50">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-calendar-times text-orange-600"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-gray-800 text-xs truncate">{{ $pesanan->kode_pesanan }}</p>
                                                <p class="text-xs text-gray-600 mt-1 truncate">{{ $pesanan->nama_pemesan }}</p>
                                                <p class="text-xs text-orange-600 font-semibold mt-1">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    {{ $daysLeft == 0 ? 'Hari ini!' : $daysLeft . ' hari lagi' }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-md font-medium whitespace-nowrap">
                                                Urgent
                                            </span>
                                        </div>
                                    </a>
                                    @endforeach
                                    
                                    @if($deadlineMendekatiCount > 5)
                                    <a href="{{ route('pesanan.index') }}" 
                                       class="block px-5 py-2 text-center text-xs text-blue-600 hover:bg-blue-50 font-semibold transition-all">
                                        Lihat {{ $deadlineMendekatiCount - 5 }} pesanan lainnya →
                                    </a>
                                    @endif
                                </div>
                            @endif

                        @else
                            {{-- Empty State --}}
                            <div class="py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-bell-slash text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-semibold">Tidak ada notifikasi</p>
                                <p class="text-xs text-gray-400 mt-1">Semua dalam kondisi baik</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- User Menu Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 p-2 hover:bg-blue-700/50 rounded-lg transition-all">
                    <div class="w-8 h-8 {{ Auth::user()->isAdmin() ? 'bg-gradient-to-br from-yellow-500 to-yellow-600' : 'bg-gradient-to-br from-blue-600 to-blue-700' }} text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <i class="fas fa-chevron-down text-xs text-white"></i>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50"
                     style="display: none;">
                    
                    {{-- User Info --}}
                    <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 {{ Auth::user()->isAdmin() ? 'bg-gradient-to-br from-yellow-500 to-yellow-600' : 'bg-gradient-to-br from-blue-600 to-blue-700' }} text-white rounded-full flex items-center justify-center font-bold text-lg shadow-md">
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-all font-semibold">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Alpine.js for dropdown --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Real-time clock --}}
<script>
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    updateTime();
    setInterval(updateTime, 1000);
</script>