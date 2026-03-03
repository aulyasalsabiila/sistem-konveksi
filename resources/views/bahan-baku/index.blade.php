@extends('layouts.app')

@section('title', 'Data Bahan Baku')
@section('page-title', 'Data Bahan Baku')
@section('page-subtitle', 'Kelola stok bahan baku')

@section('content')
<div class="space-y-6">

    <!-- Alert Stok Menipis -->
    @if($stokMenurunCount > 0)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <i class="fas fa-exclamation-triangle text-red-500 text-base"></i>
            <h4 class="font-bold text-red-800">
                {{ $stokMenurunCount }} Bahan Stok Menipis
            </h4>
        </div>
        <p class="text-xs text-red-700">
            Segera lakukan restock untuk bahan yang di bawah minimum stok
        </p>
    </div>
    @endif

    {{-- ================= FILTER & ACTION ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form method="GET" action="{{ route('bahan-baku.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_auto_auto] gap-4">

                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kode / nama bahan..."
                           class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>

                {{-- Kategori --}}
                <select name="kategori"
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach(['Kain','Aksesoris','Sablon','Kemasan'] as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                            {{ $kat }}
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
                <a href="{{ route('bahan-baku.create') }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </form>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-200 border-b">
                    <tr class="text-gray-700">
                        <th class="px-6 py-4 text-left font-semibold">Kode</th>
                        <th class="px-6 py-4 text-left font-semibold min-w-[140px]">Nama Bahan</th>
                        <th class="px-6 py-4 text-center font-semibold">Kategori</th>
                        <th class="w-[56px] px-2 py-3 text-center font-semibold text-gray-600">Stok</th>
                        <th class="w-[56px] px-2 py-3 text-center font-semibold text-gray-600">Min. Stok</th>
                        <th class="px-6 py-4 text-left font-semibold">Harga</th>
                        <th class="px-6 py-4 text-center font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($bahanBakus as $bahan)
                    @php
                        $statusStok = $bahan->stok >= $bahan->minimum_stok ? 'Aman' : ($bahan->stok > 0 ? 'Menipis' : 'Habis');
                        $statusColors = [
                            'Aman' => 'bg-green-100 text-green-700',
                            'Menipis' => 'bg-yellow-100 text-yellow-700',
                            'Habis' => 'bg-red-100 text-red-700',
                        ];
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        {{-- Kode --}}
                        <td class="px-6 py-4 font-bold text-xs text-blue-600">
                            {{ $bahan->kode_bahan }}
                        </td>

                        {{-- Nama Bahan --}}
                        <td class="px-6 py-4 text-xs">
                            <p class="font-medium text-gray-800">{{ $bahan->nama_bahan }}</p>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-6 py-4 text-center text-xs">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                {{ $bahan->kategori }}
                            </span>
                        </td>

                        {{-- Stok --}}
                        <td class="px-6 py-4 text-center font-medium text-gray-800">
                            {{ $bahan->stok }} {{ $bahan->satuan }}
                        </td>

                        {{-- Min Stok --}}
                        <td class="px-6 py-4 text-center font-medium text-gray-600">
                            {{ $bahan->minimum_stok }} {{ $bahan->satuan }}
                        </td>

                        {{-- Harga --}}
                        <td class="px-6 py-4 text-center font-medium text-gray-800">
                            {{ number_format($bahan->harga_satuan, 0, ',', '.') }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2 py-1 rounded-full font-medium {{ $statusColors[$statusStok] }}">
                                {{ $statusStok }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('bahan-baku.edit', $bahan->id) }}"
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('bahan-baku.restock.form', $bahan->id) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg"
                                   title="Restock">
                                    <i class="fas fa-boxes"></i>
                                </a>

                                <form method="POST" action="{{ route('bahan-baku.destroy', $bahan->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus bahan ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-xl mb-3 block text-gray-300"></i>
                            Tidak ada data bahan baku
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bahanBakus->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $bahanBakus->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentStok = 0;
let currentSatuan = '';

function openModal(mode, id = null) {
    const modal = document.getElementById('bahanModal');
    const form = document.getElementById('bahanForm');
    const title = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    
    if (mode === 'create') {
        title.textContent = 'Tambah Bahan Baku';
        form.action = '{{ route("bahan-baku.store") }}';
        methodField.innerHTML = '';
        form.reset();
    } else {
        title.textContent = 'Edit Bahan Baku';
        fetch(`/bahan-baku/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('nama_bahan').value = data.nama_bahan;
                document.getElementById('kategori').value = data.kategori;
                document.getElementById('stok').value = data.stok;
                document.getElementById('satuan').value = data.satuan;
                document.getElementById('minimum_stok').value = data.minimum_stok;
                document.getElementById('harga_satuan').value = data.harga_satuan;
                document.getElementById('supplier').value = data.supplier || '';
                document.getElementById('kontak_supplier').value = data.kontak_supplier || '';
            });
        
        form.action = `/bahan-baku/${id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    }
    
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('bahanModal').classList.add('hidden');
}

function openRestockModal(id, nama, stok, satuan) {
    currentStok = parseFloat(stok);
    currentSatuan = satuan;

    document.getElementById('restock_bahan_id').value = id;
    document.getElementById('restock_nama_bahan').textContent = nama;
    document.getElementById('restock_stok_current').textContent = stok + ' ' + satuan;
    document.getElementById('restockForm').action = `{{ url('/bahan-baku') }}/${id}/restock`;
    document.getElementById('jumlah_restock').value = '';
    
    updateRestockPreview();
    document.getElementById('restockModal').classList.remove('hidden');
}

function closeRestockModal() {
    document.getElementById('restockModal').classList.add('hidden');
}

document.getElementById('jumlah_restock')?.addEventListener('input', updateRestockPreview);

function updateRestockPreview() {
    const jumlah = parseFloat(document.getElementById('jumlah_restock').value) || 0;
    const newStok = currentStok + jumlah;
    document.getElementById('restock_stok_new').textContent = newStok.toFixed(2) + ' ' + currentSatuan;
}

// Close modal when clicking outside
document.getElementById('bahanModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.getElementById('restockModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRestockModal();
});
</script>
@endpush