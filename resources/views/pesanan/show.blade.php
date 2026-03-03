@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', $pesanan->kode_pesanan)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back & Actions -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <a href="{{ route('pesanan.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Informasi Pemesan -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-5 flex items-center gap-2">
                <i class="fas fa-user text-blue-600"></i> Informasi Pemesan
            </h3>

            <div class="space-y-4 text-xs">
                <div>
                    <p class="text-gray-500 mb-1">Nama Pemesan</p>
                    <p class="font-medium text-gray-900">{{ $pesanan->nama_pemesan }}</p>
                </div>

                <div>
                    <p class="text-gray-500 mb-1">Kontak</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->kontak) }}"
                       target="_blank"
                       class="font-medium text-gray-900 hover:text-green-600 hover:underline">
                        {{ $pesanan->kontak }}
                    </a>
                </div>

                @if($pesanan->alamat)
                <div>
                    <p class="text-gray-500 mb-1">Alamat</p>
                    <p class="text-gray-900">{{ $pesanan->alamat }}</p>
                </div>
                @endif

                <div>
                    <p class="text-gray-500 mb-1">Status</p>
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
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pesanan->status] }}">
                        {{ $pesanan->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Pesanan -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-5 flex items-center gap-2">
                <i class="fas fa-box text-green-600"></i> Detail Pesanan
            </h3>

            <div class="space-y-4 text-xs">
                <div>
                    <p class="text-gray-500 mb-1">Produk</p>
                    <p class="font-medium">{{ $pesanan->jenis_produk }}</p>
                </div>

                <div>
                    <p class="text-gray-500 mb-1">Ukuran</p>
                    <p class="font-medium">{{ $pesanan->ukuran }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Jumlah</p>
                    <p class="font-medium">{{ $pesanan->jumlah }} pcs</p>
                </div>

                <div>
                    <p class="text-gray-500 mb-1">Warna</p>
                    <p class="font-medium">{{ $pesanan->warna }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Harga -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-emerald-600"></i> Rincian Harga
        </h3>

        <div class="space-y-3 text-xs">
            <div class="flex justify-between">
                <span class="text-gray-500">Harga Satuan</span>
                <span class="font-medium">
                    Rp {{ number_format($pesanan->harga_per_pcs,0,',','.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Jumlah</span>
                <span class="font-medium">{{ $pesanan->jumlah }} pcs</span>
            </div>

            <div class="border-t pt-3 flex justify-between items-center">
                <span class="font-semibold">Total Harga</span>
                <span class="font-bold text-base text-gray-800">
                    Rp {{ number_format($pesanan->total_harga,0,',','.') }}
                </span>
            </div>
        </div>

        @if($pesanan->dp > 0)
        <div class="border-t mt-4 pt-4 space-y-2 text-xs">
            <div class="flex justify-between items-center">
                <span class="text-gray-600 font-medium">Down Payment (DP)</span>
                <span class="font-bold text-sm text-gray-800">
                    Rp {{ number_format($pesanan->dp, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between items-center text-red-600">
                <span class="font-semibold">Sisa Pembayaran</span>
                <span class="font-bold text-sm">
                    Rp {{ number_format($pesanan->sisa_pembayaran, 0, ',', '.') }}
                </span>
            </div>
        </div>
        @endif
    </div>

    <!-- Catatan -->
    @if($pesanan->keterangan)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
            <i class="fas fa-sticky-note text-yellow-600"></i> Catatan
        </h3>
        <p class="text-xs text-gray-700 whitespace-pre-line">{{ $pesanan->keterangan }}</p>
    </div>
    @endif

</div>
@endsection