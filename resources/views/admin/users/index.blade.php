@extends('layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')
@section('page-subtitle', 'Kelola akun pengguna sistem')

@section('content')
<div class="space-y-6">

    {{-- ================= FILTERS ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_auto_auto] gap-4">
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama atau email..."
                           class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                {{-- Role Filter --}}
                <select name="role" 
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>

                {{-- Search Button --}}
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>

                {{-- Add User Button --}}
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-user-plus"></i>
                    Tambah
                </a>
            </div>
        </form>
    </div>

    {{-- ================= USERS TABLE ================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-200 border-b">
                    <tr class="text-gray-700">
                        <th class="px-6 py-4 text-center font-semibold">User</th>
                        <th class="px-6 py-4 text-center font-semibold">Email</th>
                        <th class="px-6 py-4 text-center font-semibold">Role</th>
                        <th class="px-6 py-4 text-center font-semibold">Last Activity</th>
                        <th class="px-6 py-4 text-center font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- User --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 {{ $user->role == 'admin' ? 'bg-gradient-to-br from-yellow-500 to-yellow-600' : 'bg-gradient-to-br from-blue-600 to-blue-700' }} text-white rounded-full flex items-center justify-center font-bold shadow-md">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-xs text-gray-800">{{ $user->name }}</p>
                                    @if($user->id === auth()->id())
                                    <span class="text-xs text-blue-600 font-semibold">(You)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        {{-- Email --}}
                        <td class="px-6 py-4 text-center text-xs text-gray-600">
                            {{ $user->email }}
                        </td>
                        
                        {{-- Role --}}
                        <td class="px-6 py-4 text-center">
                            @if($user->role == 'admin')
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Admin
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Staff
                            </span>
                            @endif
                        </td>
                        
                        {{-- Last Activity --}}
                        <td class="px-6 py-4 text-center text-gray-600">
                            @php
                                $lastActivity = \App\Models\ActivityLog::where('user_id', $user->id)->latest()->first();
                            @endphp
                            @if($lastActivity)
                                <span class="text-xs">{{ $lastActivity->created_at->diffForHumans() }}</span>
                            @else
                                <span class="text-xs text-gray-400">Belum ada aktivitas</span>
                            @endif
                        </td>
                        
                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @php
                                $isActive = \App\Models\ActivityLog::where('user_id', $user->id)
                                    ->where('created_at', '>=', now()->subMinutes(15))
                                    ->exists();
                            @endphp
                            @if($isActive)
                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Online
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                Offline
                            </span>
                            @endif
                        </td>
                        
                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="p-2 text-gray-400 cursor-not-allowed rounded-lg opacity-50"
                                        title="Tidak dapat menghapus akun sendiri"
                                        disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-gray-300 text-4xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Tidak ada data user</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection