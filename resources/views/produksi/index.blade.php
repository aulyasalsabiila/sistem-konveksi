@extends('layouts.app')

@section('title', 'Data Produksi')
@section('page-title', 'Tracking Produksi')
@section('page-subtitle', 'Monitor progress produksi pesanan')

@section('content')
<div class="space-y-6"> 

    {{-- ================= FILTER & ACTION ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form method="GET" action="{{ route('produksi.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr_auto_auto] gap-4">
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari kode pesanan..."
                           class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>
                
                {{-- Stage Filter --}}
                <select name="stage" 
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Tahap</option>
                    <option value="Persiapan" {{ request('stage') == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                    <option value="Potong" {{ request('stage') == 'Potong' ? 'selected' : '' }}>Potong</option>
                    <option value="Jahit" {{ request('stage') == 'Jahit' ? 'selected' : '' }}>Jahit</option>
                    <option value="Finishing" {{ request('stage') == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                    <option value="QC" {{ request('stage') == 'QC' ? 'selected' : '' }}>QC</option>
                    <option value="Packing" {{ request('stage') == 'Packing' ? 'selected' : '' }}>Packing</option>
                </select>
                
                {{-- Status Filter --}}
                <select name="status" 
                        class="text-xs px-4 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Progress" {{ request('status') == 'Progress' ? 'selected' : '' }}>Progress</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                </select>
                
                {{-- Search Button --}}
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg
                               flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>
                
                {{-- Timeline Button --}}
                <a href="{{ route('produksi.timeline') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg
                          flex items-center gap-2 transition whitespace-nowrap">
                    <i class="fas fa-stream"></i>
                    Timeline
                </a>
            </div>
        </form>
    </div>

    {{-- ================= PRODUCTION CARDS ================= --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($produksis as $produksi)
        @php
            $pesanan = $produksi->pesanan;
            $deadline = \Carbon\Carbon::parse($pesanan->deadline);
            $daysLeft = $deadline->diffInDays(now());
            $isUrgent = $daysLeft <= 3 && $produksi->status != 'Done';
        @endphp
        
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-gray-100">
            {{-- Header --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-base font-bold text-blue-600">{{ $pesanan->kode_pesanan }}</h3>
                            @php
                                $statusColors = [
                                    'Done' => 'bg-green-100 text-green-700',
                                    'Progress' => 'bg-yellow-100 text-yellow-700',
                                    'Pending' => 'bg-gray-100 text-gray-700',
                                ];
                                $statusText = [
                                    'Done' => 'Selesai',
                                    'Progress' => 'Sedang Progress',
                                    'Pending' => 'Pending',
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$produksi->status] }}">
                                {{ $statusText[$produksi->status] }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-800 font-medium">{{ $pesanan->jenis_produk }} • {{ $pesanan->nama_pemesan }}</p>
                        <p class="text-xs text-gray-500">{{ $pesanan->jumlah }} pcs</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-sm font-semibold {{ $isUrgent ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $deadline->format('d/m/Y') }}
                        </p>
                        @if($produksi->status != 'Done')
                            <p class="text-xs {{ $isUrgent ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                @if($isUrgent)
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                @endif
                                {{ (int) $daysLeft }} hari lagi
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Progress Section --}}
            <div class="p-6 bg-gray-50">
                {{-- Progress Bar --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-700">
                            Tahap: <span class="text-blue-600">{{ $produksi->stage }}</span>
                        </span>
                        <span class="text-xs font-bold {{ $produksi->progress_percentage >= 100 ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $produksi->progress_percentage }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $produksi->progress_percentage >= 100 ? 'bg-green-500' : 'bg-gradient-to-r from-blue-500 to-blue-600' }}" 
                             style="width: {{ $produksi->progress_percentage }}%"></div>
                    </div>
                </div>

                {{-- Timeline Stages --}}
                <div class="relative">
                    <div class="flex items-center justify-between">
                        @php
                            $stages = ['Persiapan', 'Potong', 'Jahit', 'Finishing', 'QC', 'Packing'];
                            $currentIndex = array_search($produksi->stage, $stages);
                        @endphp
                        
                        @foreach($stages as $index => $stage)
                            @php
                                $isCompleted = $index < $currentIndex;
                                $isCurrent = $stage === $produksi->stage;
                                $isPending = $index > $currentIndex;
                            @endphp
                            <div class="flex flex-col items-center flex-1">
                                {{-- Circle --}}
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all mb-2
                                            {{ $isCompleted ? 'bg-green-500 text-white' : ($isCurrent ? 'bg-blue-500 text-white ring-4 ring-blue-200' : 'bg-gray-300 text-gray-600') }}">
                                    @if($isCompleted)
                                        <i class="fas fa-check"></i>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                
                                {{-- Label --}}
                                <span class="text-xs font-medium text-center {{ $isCurrent ? 'text-blue-600 font-bold' : 'text-gray-600' }}">
                                    {{ $stage }}
                                </span>
                                
                                {{-- Connector Line --}}
                                @if($index < count($stages) - 1)
                                    <div class="absolute top-4 left-0 right-0 h-0.5 -z-10" style="left: {{ (($index + 1) / count($stages)) * 100 }}%; width: {{ (1 / count($stages)) * 100 }}%;">
                                        <div class="h-full {{ $index < $currentIndex ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Details & Actions --}}
            <div class="p-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    {{-- Info Details --}}
                    <div class="flex flex-wrap gap-4 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-blue-600"></i>
                            <span><strong>PIC:</strong> {{ $produksi->pic ?? 'Belum ditentukan' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-green-600"></i>
                            <span><strong>Mulai:</strong> {{ $produksi->tanggal_mulai ? \Carbon\Carbon::parse($produksi->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                        </div>
                        @if($produksi->estimasi_selesai)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-flag-checkered text-orange-600"></i>
                            <span><strong>Target:</strong> {{ \Carbon\Carbon::parse($produksi->estimasi_selesai)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <a href="{{ route('pesanan.show', $pesanan->id) }}" 
                           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs flex items-center gap-2 transition">
                            Detail
                        </a>
                        <a href="{{ route('produksi.edit', $produksi->id) }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs flex items-center gap-2 transition">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                    </div>
                </div>

                {{-- Catatan --}}
                @if($produksi->catatan)
                <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                    <p class="text-xs text-gray-700">
                        <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>
                        <strong>Catatan:</strong> {{ $produksi->catatan }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-industry text-gray-300 text-4xl"></i>
                </div>
                <p class="text-gray-500 font-medium mb-2">Tidak ada data produksi</p>
                <p class="text-gray-400 text-xs">Produksi akan muncul otomatis ketika pesanan dikonfirmasi</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($produksis) && $produksis->hasPages())
    <div class="bg-white rounded-xl shadow-sm p-4">
        {{ $produksis->links() }}
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function openUpdateModal(id, stage, progress, pic) {
    document.getElementById('update_produksi_id').value = id;
    document.getElementById('update_stage').value = stage;
    document.getElementById('update_progress').value = progress;
    document.getElementById('update_pic').value = pic || '';
    updateProgressDisplay();
    
    document.getElementById('updateForm').action = `/produksi/${id}`;
    document.getElementById('updateModal').classList.remove('hidden');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

function updateProgressDisplay() {
    const progress = document.getElementById('update_progress').value;
    document.getElementById('progress_display').textContent = progress + '%';
}

// Auto-update status based on progress
document.getElementById('update_progress')?.addEventListener('input', function() {
    const progress = parseInt(this.value);
    const statusSelect = document.getElementById('update_status');
    
    if (progress === 0) {
        statusSelect.value = 'Pending';
    } else if (progress === 100) {
        statusSelect.value = 'Done';
    } else {
        statusSelect.value = 'Progress';
    }
});

// Close modal when clicking outside
document.getElementById('updateModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeUpdateModal();
});
</script>
@endpush