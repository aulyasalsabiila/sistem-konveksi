@extends('layouts.app')

@section('title', 'Restock Bahan Baku')
@section('page-title', 'Restock Bahan Baku')
@section('page-subtitle', 'Tambah stok bahan baku')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('bahan-baku.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="p-6">

            {{-- Form --}}
            <form method="POST" action="{{ route('bahan-baku.restock', $bahanBaku->id) }}">
                @csrf

                {{-- Section Header --}}
                <div class="flex items-center gap-3 pb-4 border-b border-gray-200 mb-6">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus-circle text-green-600"></i>
                    </div>
                    <h4 class="text-base font-bold text-gray-800">
                        Detail Restock
                    </h4>
                </div>

                {{-- Input --}}
                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-700 mb-2">
                        Jumlah Restock ({{ $bahanBaku->satuan }})
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input
                            type="number"
                            name="jumlah_restock"
                            id="jumlah_restock"
                            min="1"
                            step="0.01"
                            required
                            placeholder="0"
                            oninput="calculateNewStock()"
                            class="w-full px-4 py-2 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        />
                    </div>

                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>
                        Jumlah bahan yang ditambahkan
                    </p>
                </div>

                {{-- Preview Stok Baru --}}
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-xs font-semibold text-gray-600 mb-2">
                        Stok Setelah Restock
                    </p>

                    <div class="flex items-end gap-2">
                        <p class="text-xl font-bold text-green-600" id="new_stock">
                            {{ number_format($bahanBaku->stok, 0, ',', '.') }}
                        </p>
                        <span class="text-xs text-gray-500 mb-1">
                            {{ $bahanBaku->satuan }}
                        </span>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculateNewStock() {
    const currentStock = {{ $bahanBaku->stok }};
    const restock = parseFloat(document.getElementById('jumlah_restock').value) || 0;
    document.getElementById('new_stock').textContent =
        (currentStock + restock).toLocaleString('id-ID');
}
</script>
@endsection