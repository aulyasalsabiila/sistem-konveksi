@extends('layouts.app')

@section('title', 'Activity History')
@section('page-title', 'Activity History')
@section('page-subtitle', 'Riwayat aktivitas sistem lengkap')

@section('content')
<div class="space-y-6">

    {{-- ================= FILTERS ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <form method="GET" action="{{ route('history.index') }}">
            {{-- Main Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr_1fr_auto] gap-4 items-end">
                {{-- Search --}}
                <div>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari aktivitas atau user..."
                               class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Action Filter --}}
                <div>
                    <select name="action" 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Aksi</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                    </select>
                </div>

                {{-- User Filter --}}
                <div>
                    <select name="user_id" 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Module Filter --}}
                <div>
                    <select name="model" 
                            class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Modul</option>
                        <option value="Pesanan" {{ request('model') == 'Pesanan' ? 'selected' : '' }}>Pesanan</option>
                        <option value="BahanBaku" {{ request('model') == 'BahanBaku' ? 'selected' : '' }}>Bahan Baku</option>
                        <option value="Produksi" {{ request('model') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                    </select>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>

            {{-- Date Range Filter --}}
            <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-4 mt-4 pt-2 border-t border-gray-200">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <a href="{{ route('history.index') }}" 
                       class="w-full bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition text-center">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= ACTIVITY TIMELINE ================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-100 to-gray-200 px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-blue-600 text-base"></i>
                </div>
                Riwayat Aktivitas ({{ $activities->total() }})
            </h3>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($activities as $activity)
            <div class="p-6 hover:bg-gray-50 transition-all">
                <div class="flex gap-4">
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        @php
                            $iconConfig = [
                                'create' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
                                'update' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                                'delete' => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
                                'login' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                                'logout' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                            ];
                            $config = $iconConfig[$activity->action] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                        @endphp
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $config['bg'] }}">
                            <i class="fas {{ $activity->icon }} text-lg {{ $config['text'] }}"></i>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="font-bold text-sm text-gray-800">{{ $activity->user->name }}</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $activity->badge_color }}">
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                    @if($activity->model)
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $activity->model }}
                                    </span>
                                    @endif
                                </div>
                                <p class="text-xs font-medium text-gray-700">{{ $activity->description }}</p>
                            </div>
                            <div class="text-right text-xs text-gray-500 ml-4">
                                <p class="font-medium">{{ $activity->created_at->format('d/m/Y') }}</p>
                                <p class="font-medium">{{ $activity->created_at->format('H:i') }}</p>
                            </div>
                        </div>

                        {{-- Changes Detail --}}
                        @if($activity->changes && $activity->action == 'update')
                        <details class="mt-3">
                            <summary class="cursor-pointer text-xs text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-info-circle mr-1"></i>Lihat Detail Perubahan
                            </summary>
                            <div class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="font-semibold text-xs text-gray-700 mb-2 flex items-center gap-2">
                                            <i class="fas fa-arrow-left text-xs text-red-600"></i>
                                            Sebelum
                                        </p>
                                        <pre class="text-xs bg-white p-3 rounded border border-gray-200 overflow-x-auto">{{ json_encode($activity->changes['old'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-xs text-gray-700 mb-2 flex items-center gap-2">
                                            <i class="fas fa-arrow-right text-xs text-green-600"></i>
                                            Sesudah
                                        </p>
                                        <pre class="text-xs bg-white p-3 rounded border border-gray-200 overflow-x-auto">{{ json_encode($activity->changes['new'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </details>
                        @endif

                        {{-- Additional Info --}}
                        <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-network-wired"></i>
                                {{ $activity->ip_address }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock"></i>
                                {{ $activity->created_at->timezone('Asia/Jakarta')->locale('id')->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-history text-gray-300 text-4xl"></i>
                </div>
                <p class="text-gray-500 text-base font-medium mb-2">Belum ada aktivitas yang tercatat</p>
                <p class="text-gray-400 text-xs">Aktivitas akan muncul ketika user melakukan perubahan data</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($activities->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $activities->links() }}
        </div>
        @endif
    </div>

</div>
@endsection