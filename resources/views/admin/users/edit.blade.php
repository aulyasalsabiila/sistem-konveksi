@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Update informasi user')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">

            {{-- ================= INFORMASI PENGGUNA ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-600">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Pengguna</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="John Doe">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="john@example.com">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ================= ROLE & ACCESS ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-green-600">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Role & Akses</h3>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" required
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-gray-700">
                            <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                            <strong>Admin</strong> memiliki akses penuh ke seluruh sistem, 
                            <strong>Staff</strong> memiliki akses terbatas sesuai kebutuhan operasional
                        </p>
                    </div>
                </div>
            </div>

            {{-- ================= KEAMANAN (OPTIONAL) ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-orange-600">
                    <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lock text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Keamanan</h3>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-6">
                    <p class="text-xs text-gray-700">
                        <i class="fas fa-info-circle text-yellow-600 mr-1"></i>
                        Kosongkan field password jika tidak ingin mengubah password
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" name="password"
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Min. 8 karakter">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" name="password_confirmation"
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Ulangi password baru">
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