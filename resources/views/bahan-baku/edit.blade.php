@extends('layouts.app')

@section('title', 'Edit Bahan Baku')
@section('page-title', 'Edit Bahan Baku')
@section('page-subtitle', 'Update data bahan baku')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('bahan-baku.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('bahan-baku.update', $bahanBaku->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">

            {{-- ================= INFORMASI BAHAN ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-green-600">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Bahan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Bahan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Nama Bahan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_bahan" 
                            value="{{ old('nama_bahan', $bahanBaku->nama_bahan) }}"
                            required 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama_bahan') border-red-500 @enderror" 
                            placeholder="Cotton Combed 30s"
                        />
                        @error('nama_bahan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="kategori" 
                            required 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('kategori') border-red-500 @enderror"
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="Kain" {{ old('kategori', $bahanBaku->kategori) == 'Kain' ? 'selected' : '' }}>Kain</option>
                            <option value="Aksesoris" {{ old('kategori', $bahanBaku->kategori) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            <option value="Sablon" {{ old('kategori', $bahanBaku->kategori) == 'Sablon' ? 'selected' : '' }}>Sablon</option>
                            <option value="Kemasan" {{ old('kategori', $bahanBaku->kategori) == 'Kemasan' ? 'selected' : '' }}>Kemasan</option>
                        </select>
                        @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ================= STOK & SATUAN ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-600">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Stok & Satuan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Stok Saat Ini --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Stok Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="stok" 
                            value="{{ old('stok', $bahanBaku->stok) }}"
                            min="0" 
                            step="0.01" 
                            required 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('stok') border-red-500 @enderror" 
                            placeholder="100"
                        />
                        @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Satuan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="satuan" 
                            value="{{ old('satuan', $bahanBaku->satuan) }}"
                            required 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('satuan') border-red-500 @enderror" 
                            placeholder="meter, kg, pcs, cone"
                        />
                        @error('satuan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Minimum Stok --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Minimum Stok <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="minimum_stok" 
                            value="{{ old('minimum_stok', $bahanBaku->minimum_stok) }}"
                            min="0" 
                            step="0.01" 
                            required 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('minimum_stok') border-red-500 @enderror" 
                            placeholder="50"
                        />
                        @error('minimum_stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i>
                            Sistem akan memberikan notifikasi jika stok di bawah nilai ini
                        </p>
                    </div>

                    {{-- Harga per Satuan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Harga Satuan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs">
                                Rp
                            </div>
                            <input 
                                type="number" 
                                name="harga_satuan" 
                                value="{{ old('harga_satuan', $bahanBaku->harga_satuan) }}"
                                min="0"
                                step="100"
                                required
                                class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('harga_satuan') border-red-500 @enderror"
                                placeholder="35000"
                            />
                        </div>
                        @error('harga_satuan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ================= INFORMASI SUPPLIER ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-orange-600">
                    <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Supplier</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Supplier --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Nama Supplier
                        </label>
                        <input 
                            type="text" 
                            name="supplier" 
                            value="{{ old('supplier', $bahanBaku->supplier) }}"
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('supplier') border-red-500 @enderror" 
                            placeholder="Toko Kain Jaya"
                        />
                        @error('supplier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Kontak Supplier --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Kontak Supplier
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2">
                                <i class="fab fa-whatsapp text-green-600"></i>
                            </div>
                            <input 
                                type="text" 
                                name="kontak_supplier" 
                                value="{{ old('kontak_supplier', $bahanBaku->kontak_supplier) }}"
                                class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('kontak_supplier') border-red-500 @enderror"
                                placeholder="081234567890"
                            />
                        </div>
                        @error('kontak_supplier')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="p-6 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-600 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Pastikan semua data sudah benar sebelum menyimpan
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" 
                                class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection