@extends('layouts.app')

@section('title', 'Data Customer')
@section('page-title', 'Data Customer')
@section('page-subtitle', 'Database pelanggan dan riwayat pesanan')

@section('content')
<div class="space-y-6">

    {{-- ================= FILTER & SEARCH ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <form method="GET" action="{{ route('customers.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-[2fr_auto] gap-4">
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama customer atau kontak..."
                           class="w-full text-xs pl-10 pr-4 py-2 border border-gray-300 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>
                
                {{-- Search Button --}}
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-6 py-2 rounded-lg
                               flex items-center gap-2 transition">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    {{-- ================= CUSTOMER CARDS ================= --}}
    <div class="grid grid-cols-1 gap-4">
        @forelse($customers as $customer)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all border border-gray-100">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-md">
                        {{ substr($customer['nama'], 0, 1) }}
                    </div>
                    
                    {{-- Customer Info --}}
                    <div class="flex-1">
                        {{-- Name & Badge --}}
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-sm font-bold text-gray-800">{{ $customer['nama'] }}</h3>
                            @if($customer['total_pesanan'] >= 3)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold flex items-center gap-1">
                                    VIP
                                </span>
                            @elseif($customer['total_pesanan'] > 1)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                    Repeat
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                    New
                                </span>
                            @endif
                        </div>
                        
                        {{-- Contact Info --}}
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 mb-4">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-green-600"></i>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer['kontak']) }}" 
                                   target="_blank" 
                                   class="hover:text-green-600 hover:underline">
                                    {{ $customer['kontak'] }}
                                </a>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar text-blue-600"></i>
                                <span>Last Order: {{ \Carbon\Carbon::parse($customer['last_order'])->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        {{-- Stats Grid --}}
                        <div class="grid grid-cols-3 gap-3 mb-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                                <p class="text-base font-bold text-blue-600">{{ $customer['total_pesanan'] }}</p>
                                <p class="text-xs text-gray-600 mt-1">Total Pesanan</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                                <p class="text-base font-bold text-green-600">Rp {{ number_format($customer['total_nilai'], 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mt-1">Total Nilai</p>
                            </div>
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-center">
                                <p class="text-base font-bold text-orange-600">Rp {{ number_format($customer['total_nilai'] / $customer['total_pesanan'], 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mt-1">Avg. Order</p>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <button onclick="openHistoryModal('{{ $customer['nama'] }}', '{{ $customer['kontak'] }}')" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-lg flex items-center justify-center gap-2 transition shadow-md hover:shadow-lg">
                            <i class="fas fa-history"></i>
                            Lihat Riwayat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users text-gray-300 text-xl"></i>
                </div>
                <p class="text-gray-500 text-base font-medium mb-2">Belum ada data customer</p>
                <p class="text-gray-400 text-xs">Customer akan muncul otomatis dari data pesanan</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- ================= TOP CUSTOMERS TABLE ================= --}}
    @if($customers->count() > 0)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                Top 5 Customer (by Total Value)
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-100 border-b">
                    <tr class="text-gray-700">
                        <th class="px-6 py-4 text-center font-semibold">Rank</th>
                        <th class="px-6 py-4 text-left font-semibold">Customer</th>
                        <th class="px-6 py-4 text-center font-semibold">Total Pesanan</th>
                        <th class="px-6 py-4 text-left font-semibold">Total Nilai</th>
                        <th class="px-6 py-4 text-center font-semibold">Last Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($customers->sortByDesc('total_nilai')->take(5) as $index => $customer)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-center">
                            @if($index == 0)
                                <i class="fas fa-trophy text-yellow-500 text-xl"></i>
                            @elseif($index == 1)
                                <i class="fas fa-medal text-gray-400 text-xl"></i>
                            @elseif($index == 2)
                                <i class="fas fa-medal text-orange-600 text-xl"></i>
                            @else
                                <span class="text-gray-600 font-bold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ substr($customer['nama'], 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-xs text-gray-900">{{ $customer['nama'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer['kontak'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-semibold text-gray-900">{{ $customer['total_pesanan'] }}x</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-green-600">Rp {{ number_format($customer['total_nilai'], 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500">
                            {{ \Carbon\Carbon::parse($customer['last_order'])->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

{{-- ================= MODAL HISTORY PESANAN ================= --}}
<div id="historyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
        {{-- Modal Header --}}
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Riwayat Pesanan</h3>
                    <p class="text-xs text-gray-600 mt-1" id="modal_customer_name"></p>
                    <p class="text-xs text-gray-600" id="modal_customer_kontak"></p>
                </div>
                <button onclick="closeHistoryModal()" 
                        class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        {{-- Modal Body --}}
        <div class="p-6 overflow-y-auto flex-1" id="history_content">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-sm text-gray-400"></i>
                <p class="text-sm text-gray-500 mt-4">Loading...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openHistoryModal(nama, kontak) {
    document.getElementById('modal_customer_name').textContent = nama;
    document.getElementById('modal_customer_kontak').textContent = 'Kontak: ' + kontak;
    document.getElementById('historyModal').classList.remove('hidden');

    fetch(`/customers/history?nama=${encodeURIComponent(nama)}`)
        .then(response => response.json())
        .then(data => displayHistory(data))
        .catch(() => {
            document.getElementById('history_content').innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-circle text-xl text-red-400"></i>
                    <p class="text-red-500 mt-4">Gagal memuat data</p>
                </div>
            `;
        });
}

function displayHistory(pesanans) {
    const content = document.getElementById('history_content');

    if (!pesanans || pesanans.length === 0) {
        content.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-inbox text-xl text-gray-400"></i>
                <p class="text-gray-500 mt-4">Belum ada riwayat pesanan</p>
            </div>
        `;
        return;
    }

    let html = `<div class="grid grid-cols-1 md:grid-cols-2 gap-4">`;

    const statusColors = {
        'Pending': 'bg-red-100 text-red-700',
        'Dikonfirmasi': 'bg-blue-100 text-blue-700',
        'Proses Produksi': 'bg-yellow-100 text-yellow-700',
        'QC': 'bg-purple-100 text-purple-700',
        'Siap Kirim': 'bg-teal-100 text-teal-700',
        'Selesai': 'bg-green-100 text-green-700'
    };

    pesanans.forEach(pesanan => {
    html += `
        <div class="border border-gray-200 rounded-lg p-4 bg-white space-y-2">

            <!-- ROW 1: Kode & Status -->
            <div class="grid grid-cols-2 items-start">
                <div>
                    <h4 class="font-bold text-blue-600">
                        ${pesanan.kode_pesanan}
                    </h4>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        ${statusColors[pesanan.status] || 'bg-gray-100 text-gray-700'}">
                        ${pesanan.status}
                    </span>
                </div>
                <!-- ROW 2: Produk -->
                <div>
                    <p class="text-xs text-gray-800">
                        ${pesanan.jenis_produk} - ${pesanan.jumlah} pcs
                    </p>
                </div>
            </div>

            <!-- ROW 3: Tanggal -->
            <div>
                <p class="text-xs text-gray-500 mb-1">Tanggal Pesan</p>
                <p class="text-xs font-semibold text-gray-800">
                    ${formatDate(pesanan.tanggal_pesan)}
                </p>
            </div>

            <!-- ROW 4: Total Harga & Detail (SEJAJAR) -->
            <div class="flex items-end justify-between">
                <!-- Total Harga -->
                <div>
                    <p class="text-xs text-gray-500 mb-1">Total Harga</p>
                    <p class="text-xs font-bold text-gray-800">
                        Rp ${formatNumber(pesanan.total_harga)}
                    </p>
                </div>

                <!-- Lihat Detail -->
                <a href="/pesanan/${pesanan.id}" 
                   class="inline-flex items-center gap-2 text-xs font-semibold
                          text-blue-600 hover:text-white
                          border border-blue-600 rounded-lg
                          px-2 py-1 hover:bg-blue-600 transition">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    `;
});


    html += '</div>';
    content.innerHTML = html;
}

function closeHistoryModal() {
    document.getElementById('historyModal').classList.add('hidden');
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID');
}

function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

document.getElementById('historyModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeHistoryModal();
});
</script>
@endpush