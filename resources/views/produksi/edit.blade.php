@extends('layouts.app')

@section('title', 'Edit Produksi')
@section('page-title', 'Edit Produksi')
@section('page-subtitle', 'Update progress produksi')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('produksi.timeline') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('produksi.update', $produksi->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            {{-- ================= INFORMASI PROGRESS ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-600">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tasks text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Progress</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Tahap Produksi <span class="text-red-500">*</span>
                        </label>
                        <select name="stage" required 
                                class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="Persiapan" {{ $produksi->stage == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                            <option value="Potong" {{ $produksi->stage == 'Potong' ? 'selected' : '' }}>Potong</option>
                            <option value="Jahit" {{ $produksi->stage == 'Jahit' ? 'selected' : '' }}>Jahit</option>
                            <option value="Finishing" {{ $produksi->stage == 'Finishing' ? 'selected' : '' }}>Finishing</option>
                            <option value="QC" {{ $produksi->stage == 'QC' ? 'selected' : '' }}>QC</option>
                            <option value="Packing" {{ $produksi->stage == 'Packing' ? 'selected' : '' }}>Packing</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status_select" required 
                                class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="Pending" {{ $produksi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Progress" {{ $produksi->status == 'Progress' ? 'selected' : '' }}>Progress</option>
                            <option value="Done" {{ $produksi->status == 'Done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Progress <span class="text-red-500">*</span>
                        </label>
                        <input type="range" name="progress_percentage" id="progress_slider" 
                               value="{{ $produksi->progress_percentage }}" min="0" max="100" step="5" 
                               class="w-full" oninput="updateProgressValue()"/>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-600">0%</span>
                            <span id="progress_value" class="text-sm font-bold text-blue-600">{{ $produksi->progress_percentage }}%</span>
                            <span class="text-xs text-gray-600">100%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= JADWAL & PIC ================= --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-green-600">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Jadwal & Penanggung Jawab</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            PIC (Person In Charge)
                        </label>
                        <input type="text" name="pic" value="{{ old('pic', $produksi->pic) }}" 
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Nama penanggung jawab"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai', $produksi->tanggal_mulai ? $produksi->tanggal_mulai->format('Y-m-d') : '') }}" 
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Estimasi Selesai
                        </label>
                        <input type="date" name="estimasi_selesai" 
                               value="{{ old('estimasi_selesai', $produksi->estimasi_selesai ? $produksi->estimasi_selesai->format('Y-m-d') : '') }}" 
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">
                            Tanggal Selesai Aktual
                        </label>
                        <input type="date" name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', $produksi->tanggal_selesai ? $produksi->tanggal_selesai->format('Y-m-d') : '') }}" 
                               class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
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
                <textarea name="catatan" rows="4" 
                          class="w-full text-xs px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                          placeholder="Catatan khusus untuk tahap produksi ini...">{{ old('catatan', $produksi->catatan) }}</textarea>
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

@push('scripts')
<script>
function updateProgressValue() {
    const progress = document.getElementById('progress_slider').value;
    document.getElementById('progress_value').textContent = progress + '%';
    
    // Auto-update status based on progress
    const statusSelect = document.getElementById('status_select');
    if (progress == 0) {
        statusSelect.value = 'Pending';
    } else if (progress == 100) {
        statusSelect.value = 'Done';
    } else {
        statusSelect.value = 'Progress';
    }
}
</script>
@endpush