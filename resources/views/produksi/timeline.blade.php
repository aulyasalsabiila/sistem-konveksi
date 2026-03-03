@extends('layouts.app')

@section('title', 'Timeline Produksi')
@section('page-title', 'Timeline Produksi')
@section('page-subtitle', 'Visualisasi timeline produksi pesanan')

@section('content')
<div class="space-y-6">
    
    {{-- ================= FILTER & ACTION ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form method="GET" action="{{ route('produksi.timeline') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr_auto_auto] gap-4">
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari kode pesanan..."
                           class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>
                
                {{-- Stage Filter --}}
                <select name="stage" 
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Tahap</option>
                    <option value="Persiapan" {{ request('stage') == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                    <option value="Potong" {{ request('stage') == 'Potong' ? 'selected' : '' }}>Potong</option>
                    <option value="Jahit" {{ request('stage') == 'Jahit' ? 'selected' : '' }}>Jahit</option>
                    <option value="Finishing" {{ request('stage') == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                    <option value="QC" {{ request('stage') == 'QC' ? 'selected' : '' }}>QC</option>
                    <option value="Packing" {{ request('stage') == 'Packing' ? 'selected' : '' }}>Packing</option>
                </select>
                
                {{-- Status Filter --}}
                <select name="status" 
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Progress" {{ request('status') == 'Progress' ? 'selected' : '' }}>Progress</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                </select>
                
                {{-- Search Button --}}
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg
                               flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>
                
                {{-- List View Button --}}
                <a href="{{ route('produksi.index') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg
                          flex items-center gap-2 transition whitespace-nowrap">
                    <i class="fas fa-list"></i>
                    List View
                </a>
            </div>
        </form>
    </div>

    {{-- ================= LEGEND ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h4 class="font-medium text-sm text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-info-circle text-blue-600"></i>
            Progress Status
        </h4>
        <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                <span class="text-xs text-gray-600">Pending</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <span class="text-xs text-gray-600">Progress</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-xs text-gray-600">Selesai</span>
            </div>
        </div>
    </div>

    {{-- ================= TIMELINE CONTAINER ================= --}}
    <div class="relative">
        {{-- Vertical Line --}}
        <div class="absolute left-11 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-600 to-blue-300"></div>
        
        <div class="space-y-6 pl-16">
            @forelse($produksis as $produksi)
            @php
                $pesanan = $produksi->pesanan;
                $deadline = \Carbon\Carbon::parse($pesanan->deadline);
                $daysLeft = (int) $deadline->diffInDays(now());
                $isUrgent = $daysLeft <= 3 && $produksi->status != 'Done';
                
                $statusConfig = [
                    'Done' => ['color' => 'green', 'icon' => 'fa-check', 'text' => 'Selesai'],
                    'Progress' => ['color' => 'yellow', 'icon' => 'fa-spinner', 'text' => 'Sedang Progress'],
                    'Pending' => ['color' => 'gray', 'icon' => 'fa-clock', 'text' => 'Pending'],
                ];
                $config = $statusConfig[$produksi->status];
            @endphp
                
            {{-- Timeline Item --}}
            <div class="relative">
                {{-- Timeline Dot --}}
                <div class="absolute -left-[68px] top-6 w-8 h-8 rounded-full flex items-center justify-center bg-{{ $config['color'] }}-500 shadow-lg ring-4 ring-white">
                    <i class="fas {{ $config['icon'] }} text-white"></i>
                </div>
                
                {{-- Card --}}
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all border-l-4 border-{{ $config['color'] }}-500">
                    {{-- Header --}}
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-base font-bold text-blue-600">{{ $pesanan->kode_pesanan }}</h3>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $produksi->stage }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-800 font-medium">{{ $pesanan->jenis_produk }} • {{ $pesanan->nama_pemesan }}</p>
                                <p class="text-xs text-gray-500">{{ $pesanan->jumlah }} pcs</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm font-semibold {{ $isUrgent ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $deadline->format('d/m/Y') }}
                                </p>
                                @if($produksi->status != 'Done')
                                    <p class="text-xs {{ $isUrgent ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        @if($isUrgent)
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                        @endif
                                        {{ $daysLeft }} hari lagi
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Progress --}}
                    <div class="p-6 bg-gray-50">
                        <div class="mb-2">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-gray-700">Progress Produksi</span>
                                <span class="text-xs font-bold {{ $produksi->progress_percentage >= 100 ? 'text-green-600' : 'text-blue-600' }}">
                                    {{ $produksi->progress_percentage }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500 {{ $produksi->progress_percentage >= 100 ? 'bg-green-500' : 'bg-gradient-to-r from-blue-500 to-blue-600' }}" 
                                     style="width: {{ $produksi->progress_percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Details & Actions --}}
                    <div class="p-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            {{-- Info Details --}}
                            <div class="flex flex-wrap gap-4 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user text-blue-600"></i>
                                    <span><strong>PIC:</strong> {{ $produksi->pic ?? 'Belum ditentukan' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-green-600"></i>
                                    <span><strong>Mulai:</strong> {{ $produksi->tanggal_mulai ? \Carbon\Carbon::parse($produksi->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                                </div>
                                @if($produksi->estimasi_selesai)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-flag-checkered text-orange-600"></i>
                                    <span><strong>Target:</strong> {{ \Carbon\Carbon::parse($produksi->estimasi_selesai)->format('d/m/Y') }}</span>
                                </div>
                                @endif
                            </div>
                    
                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                <a href="{{ route('pesanan.show', $pesanan->id) }}" 
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs flex items-center gap-2 transition">
                                    Detail
                                </a>
                                <a href="{{ route('produksi.edit', $produksi->id) }}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs flex items-center gap-2 transition">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        @if($produksi->catatan)
                        <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                            <p class="text-xs text-gray-700">
                                <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>
                                <strong>Catatan:</strong> {{ $produksi->catatan }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-stream text-gray-300 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 text-base font-medium mb-2">Belum ada timeline produksi</p>
                    <p class="text-gray-400 text-xs">Timeline akan muncul otomatis ketika pesanan mulai diproduksi</p>
                </div>
            </div>
            @endforelse
        </div>
        
        {{-- Pagination --}}
        @if(isset($produksis) && $produksis->hasPages())
        <div class="bg-white rounded-xl shadow-sm p-4 mt-6 ml-16">
            {{ $produksis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection