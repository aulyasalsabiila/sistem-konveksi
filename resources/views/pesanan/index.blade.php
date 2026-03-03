@extends('layouts.app')

@section('title', 'Data Pesanan')
@section('page-title', 'Data Pesanan')
@section('page-subtitle', 'Kelola pesanan konveksi')

@section('content')
<div class="space-y-6">

    {{-- ================= FILTER & ACTION ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form method="GET" action="{{ route('pesanan.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_auto_auto] gap-4">

                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kode, pemesan, atau produk..."
                        class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                {{-- Status --}}
                <select
                    name="status"
                    class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    @foreach(['Pending','Dikonfirmasi','Proses Produksi','QC','Siap Kirim','Selesai'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>

                {{-- Button Search --}}
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg
                           flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>

                {{-- Add --}}
                <a href="{{ route('pesanan.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg
                          flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </form>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-200 border-b">
                    <tr class="text-gray-700">
                        <th class="px-6 py-4 text-left font-semibold">Kode</th>
                        <th class="px-6 py-4 text-left font-semibold min-w-[140px]">Pemesan</th>
                        <th class="px-6 py-4 text-center font-semibold">Produk</th>
                        <th class="px-6 py-4 text-center font-semibold">Qty</th>
                        <th class="px-6 py-4 text-center font-semibold">Total</th>
                        <th class="px-6 py-4 text-center font-semibold">Deadline</th>
                        <th class="px-6 py-4 text-center font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($pesanans as $pesanan)
                    @php
                        $deadline = \Carbon\Carbon::parse($pesanan->deadline);
                        $now = now();
                        $isOverdue = $now->isAfter($deadline);
                        $daysLeft = $isOverdue ? $deadline->diffInDays($now) : $now->diffInDays($deadline);
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        {{-- Kode --}}
                        <td class="px-6 py-4 font-medium text-xs text-blue-600">
                            {{ $pesanan->kode_pesanan }}
                        </td>

                        {{-- Pemesan --}}
                        <td class="px-6 py-4 text-xs">
                            <p class="text-gray-800">{{ $pesanan->nama_pemesan }}</p>
                        </td>

                        {{-- Produk --}}
                        <td class="px-6 py-4 text-center text-xs text-gray-800">
                            {{ $pesanan->jenis_produk }}
                        </td>

                        {{-- Qty --}}
                        <td class="px-6 py-4 text-center text-xs text-gray-800">
                            {{ $pesanan->jumlah }} pcs
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-4 text-left text-xs text-gray-800">
                            {{ number_format($pesanan->total_harga,0,',','.') }}
                        </td>

                        {{-- Deadline --}}
                        <td class="px-6 py-4 text-center text-xs">
                            <p class="{{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-700' }}">
                                {{ $deadline->format('d/m/Y') }}
                            </p>
                            @if($pesanan->status != 'Selesai')
                            <p class="text-xs {{ $isOverdue ? 'text-red-600' : 'text-gray-500' }}">
                                {{ $isOverdue ? 'Terlambat '.(int) $daysLeft.' hari' : (int) $daysLeft.' hari lagi' }}
                            </p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center text-xs">
                            @php
                                $colors = [
                                    'Pending'=>'bg-red-100 text-red-700',
                                    'Dikonfirmasi'=>'bg-blue-100 text-blue-700',
                                    'Proses Produksi'=>'bg-yellow-100 text-yellow-700',
                                    'QC'=>'bg-purple-100 text-purple-700',
                                    'Siap Kirim'=>'bg-teal-100 text-teal-700',
                                    'Selesai'=>'bg-green-100 text-green-700',
                                ];
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $colors[$pesanan->status] }}">
                                {{ $pesanan->status }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('pesanan.show',$pesanan->id) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('pesanan.edit',$pesanan->id) }}"
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('pesanan.destroy',$pesanan->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> 
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-base mb-3 block text-gray-300"></i>
                            Tidak ada data pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pesanans->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $pesanans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection