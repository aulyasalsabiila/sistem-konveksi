@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-subtitle', 'Export laporan dalam format PDF')

@section('content')
<div class="space-y-6">

    {{-- ================= LAPORAN CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Laporan Pesanan --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <div class="flex items-center gap-3 mb-2">
                    <h3 class="text-base font-bold">Laporan Pesanan</h3>
                </div>
                <p class="text-blue-100 text-xs">Export data pesanan dengan filter</p>
            </div>
            
            <div class="p-6">
                <p class="text-xs text-gray-600 mb-4">
                    Export data pesanan berdasarkan periode dan status tertentu.
                </p>
                
                <form action="{{ route('laporan.pesanan') }}" method="GET" target="_blank" class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" 
                               class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" 
                               class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Proses Produksi">Proses Produksi</option>
                            <option value="QC">QC</option>
                            <option value="Siap Kirim">Siap Kirim</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="pt-3">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-lg flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Laporan Stok --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6">
                <div class="flex items-center gap-3 mb-2">
                    <h3 class="text-base font-bold">Laporan Stok</h3>
                </div>
                <p class="text-green-100 text-xs">Export data stok bahan baku</p>
            </div>
            
            <div class="p-6">
                <p class="text-xs text-gray-600 mb-4">
                    Laporan stok bahan baku saat ini, termasuk status ketersediaan dan nilai total.
                </p>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-4 space-y-3 border border-gray-200">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-xs text-gray-600 flex items-center gap-2">
                            <i class="fas fa-cube text-xs text-gray-400"></i>
                            Total Item
                        </span>
                        <span class="font-bold text-xs text-gray-800">{{ \App\Models\BahanBaku::count() }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-200">
                        <span class="text-xs text-gray-600 flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            Stok Aman
                        </span>
                        <span class="font-bold text-xs text-green-600">
                            {{ \App\Models\BahanBaku::whereColumn('stok', '>=', 'minimum_stok')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-200">
                        <span class="text-xs text-gray-600 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            Stok Menipis
                        </span>
                        <span class="font-bold text-xs text-red-600">
                            {{ \App\Models\BahanBaku::whereColumn('stok', '<', 'minimum_stok')->where('stok', '>', 0)->count() }}
                        </span>
                    </div>
                </div>

                {{-- Spacer untuk menyamakan tinggi dengan form di card lain --}}
                <div class="h-[84px]"></div>

                <form action="{{ route('laporan.stok') }}" method="GET" target="_blank">
                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-semibold py-2 rounded-lg flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </button>
                </form>
            </div>
        </div>

        {{-- Laporan Produksi --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all border border-gray-100">
            <div class="bg-gradient-to-r from-orange-600 to-orange-700 text-white p-6">
                <div class="flex items-center gap-3 mb-2">
                    <h3 class="text-base font-bold">Laporan Produksi</h3>
                </div>
                <p class="text-orange-100 text-xs">Export data produksi & performance</p>
            </div>
            
            <div class="p-6">
                <p class="text-xs text-gray-600 mb-4">
                    Performance produksi dan on-time delivery rates berdasarkan periode tertentu.
                </p>
                
                <form action="{{ route('laporan.produksi') }}" method="GET" target="_blank" class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" 
                               class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" 
                               class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"/>
                    </div>

                    {{-- Spacer untuk menyamakan tinggi dengan form di card lain --}}
                    <div class="h-[54px]"></div>

                    <div class="pt-3">
                        <button type="submit" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold py-2 rounded-lg flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= TIPS SECTION ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-start gap-4">
            <div class="flex items-center justify-center flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-600 text-sm"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-gray-800 mb-3 text-sm">Tips Penggunaan Laporan</h4>
                <div class="grid md:grid-cols-2 gap-3">
                    <div class="flex items-start gap-2 text-xs text-gray-600">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1"></div>
                        <span>Kosongkan filter tanggal untuk export semua data</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs text-gray-600">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1"></div>
                        <span>Gunakan filter status untuk laporan pesanan spesifik</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs text-gray-600">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1"></div>
                        <span>Laporan akan terbuka di tab baru dan otomatis terdownload</span>
                    </div>
                    <div class="flex items-start gap-2 text-xs text-gray-600">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1"></div>
                        <span>Format laporan: PDF landscape untuk kemudahan cetak</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection