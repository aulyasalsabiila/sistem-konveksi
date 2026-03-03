@extends('layouts.app')

@section('title', 'Tambah Pesanan')
@section('page-title', 'Tambah Pesanan')
@section('page-subtitle', 'Input data pesanan baru')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('pesanan.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            
            {{-- ================= INFORMASI PEMESAN ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-600">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Pemesan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Nama Pemesan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_pemesan') border-red-500 @enderror"
                               placeholder="PT. Contoh / Nama Individu" required>
                        @error('nama_pemesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2">
                                <i class="fab fa-whatsapp text-green-600"></i>
                            </div>
                            <input type="text" name="kontak" value="{{ old('kontak') }}"
                                   class="w-full text-xs pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kontak') border-red-500 @enderror"
                                   placeholder="081234567890" required>
                        </div>
                        @error('kontak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Alamat Pengiriman
                        </label>
                        <textarea name="alamat" rows="3" 
                                  class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Alamat lengkap untuk pengiriman (opsional)">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ================= DETAIL PESANAN ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-green-600">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-box text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Detail Pesanan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Jenis Produk <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_produk" 
                                class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                required>
                            <option value="">Pilih Jenis Produk</option>
                            @foreach(['Kaos','Polo','Seragam Sekolah','Jaket','Hoodie','Jersey Custom','Kemeja','Lainnya'] as $p)
                                <option value="{{ $p }}" {{ old('jenis_produk')==$p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="100" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Breakdown Ukuran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ukuran" value="{{ old('ukuran') }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="S(20), M(30), L(30), XL(20)" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Warna <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="warna" value="{{ old('warna') }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Hitam, Putih, Navy" required>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">
                                Spesifikasi Detail
                            </label>
                            <textarea name="spesifikasi" rows="3"
                                    class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Contoh: Bahan Cotton Combed 30s, Sablon DTF, Bordir logo dada kiri">{{ old('spesifikasi') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-2">
                                Upload Desain
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                                <input type="file" name="foto_desain" id="foto_desain" accept="image/*" class="hidden">
                                <label for="foto_desain" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-xs text-gray-600">Klik untuk upload atau drag & drop</p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG • Maksimal 2MB</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= HARGA & TIMELINE ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-orange-600">
                    <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calculator text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Harga & Timeline</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Tanggal Pesan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pesan"
                               value="{{ old('tanggal_pesan', date('Y-m-d')) }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Deadline <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="deadline"
                               value="{{ old('deadline') }}"
                               class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Harga Satuan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-500">
                                Rp
                            </div>
                            <input type="number" name="harga_per_pcs" id="harga_per_pcs" min="0"
                                   value="{{ old('harga_per_pcs') }}"
                                   class="w-full text-xs pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="50000" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Down Payment (DP)
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-500">
                                Rp
                            </div>
                            <input type="number" name="dp" min="0"
                                   value="{{ old('dp') }}"
                                   class="w-full text-xs pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="2500000">
                        </div>
                    </div>

                    {{-- TOTAL DISPLAY --}}
                    <div class="md:col-span-2">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-600 mb-1">Total Harga Pesanan</p>
                                    <p class="text-base font-bold text-blue-700" id="total_harga_display">Rp 0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= CATATAN ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-sticky-note text-yellow-600"></i>
                    <label class="block text-xs font-medium text-gray-700">
                        Catatan Tambahan
                    </label>
                </div>
                <textarea name="keterangan" rows="3"
                          class="w-full text-xs px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Catatan khusus untuk pesanan ini...">{{ old('keterangan') }}</textarea>
            </div>

            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="p-6 bg-gray-50">
                <div class="flex items-center justify-end gap-3">
                    <button type="submit"
                            class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hargaPerPcs = document.getElementById('harga_per_pcs');
    const jumlahInput = document.getElementById('jumlah');
    const totalDisplay = document.getElementById('total_harga_display');
    
    function calculateTotal() {
        const harga = parseFloat(hargaPerPcs.value) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const total = harga * jumlah;
        
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    hargaPerPcs.addEventListener('input', calculateTotal);
    jumlahInput.addEventListener('input', calculateTotal);
    
    // File upload preview
    const fileInput = document.getElementById('foto_desain');
    fileInput.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = this.nextElementSibling;
            label.querySelector('p').textContent = fileName;
        }
    });
    
    calculateTotal();
});
</script>
@endpush 