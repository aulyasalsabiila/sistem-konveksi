@extends('layouts.app')

@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer')
@section('page-subtitle', $customer->nama)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('customers.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- ================= CUSTOMER PROFILE CARD ================= --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <div class="flex items-start gap-6">
                {{-- Avatar --}}
                <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-full flex items-center justify-center font-bold text-4xl flex-shrink-0 shadow-lg">
                    {{ substr($customer->nama, 0, 1) }}
                </div>
                
                <div class="flex-1">
                    {{-- Name & Badge --}}
                    <div class="flex items-center gap-3 mb-3">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $customer->nama }}</h2>
                        @if($customer->total_pesanan >= 3)
                            <span class="px-4 py-1.5 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold flex items-center gap-2">
                                <i class="fas fa-crown"></i> VIP Customer
                            </span>
                        @elseif($customer->total_pesanan > 1)
                            <span class="px-4 py-1.5 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                Repeat Customer
                            </span>
                        @else
                            <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                New Customer
                            </span>
                        @endif
                    </div>
                    
                    {{-- Contact Info --}}
                    <div class="flex items-center gap-6 text-gray-600 mb-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone text-green-600"></i>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->kontak) }}" 
                               target="_blank" 
                               class="hover:text-green-600 hover:underline transition">
                                {{ $customer->kontak }}
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-blue-600"></i>
                            <span>Customer sejak: {{ \Carbon\Carbon::parse($customer->last_order)->format('F Y') }}</span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                            <p class="text-3xl font-bold text-blue-600">{{ $customer->total_pesanan }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Pesanan</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($customer->total_nilai, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Nilai</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-100">
                            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($customer->total_nilai / $customer->total_pesanan, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Rata-rata Order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ORDER HISTORY ================= --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-blue-600 text-lg"></i>
                </div>
                Riwayat Pesanan ({{ $pesanans->count() }})
            </h3>
        </div>
        
        <div class="p-6">
            <div class="space-y-3">
                @forelse($pesanans as $pesanan)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-blue-200 transition-all">
                    {{-- Header: Kode & Status --}}
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">{{ $pesanan->kode_pesanan }}</h4>
                            <p class="text-sm text-gray-600">{{ $pesanan->jenis_produk }} - {{ $pesanan->jumlah }} pcs</p>
                        </div>
                        @php
                            $statusColors = [
                                'Pending' => 'bg-red-100 text-red-700',
                                'Dikonfirmasi' => 'bg-blue-100 text-blue-700',
                                'Proses Produksi' => 'bg-yellow-100 text-yellow-700',
                                'QC' => 'bg-purple-100 text-purple-700',
                                'Siap Kirim' => 'bg-teal-100 text-teal-700',
                                'Selesai' => 'bg-green-100 text-green-700'
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pesanan->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $pesanan->status }}
                        </span>
                    </div>
                    
                    {{-- Details Grid --}}
                    <div class="grid grid-cols-3 gap-4 mb-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Pesan</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pesanan->tanggal_pesan->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Deadline</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pesanan->deadline->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Harga</p>
                            <p class="text-sm font-bold text-green-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    {{-- Action Link --}}
                    <a href="{{ route('pesanan.show', $pesanan->id) }}" 
                       class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-300 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium mb-2">Belum ada riwayat pesanan</p>
                    <p class="text-gray-400 text-sm">Customer ini belum pernah melakukan pemesanan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection