@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- ================= STATISTIC CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label'=>'Pesanan Bulan Ini','value'=>$totalPesananBulanIni,'color'=>'blue','icon'=>'fa-shopping-cart'],
                ['label'=>'Revenue Bulan Ini','value'=>'Rp '.number_format($totalRevenueBulanIni,0,',','.'),'color'=>'green','icon'=>'fa-wallet'],
                ['label'=>'Dalam Produksi','value'=>$pesananProses,'color'=>'yellow','icon'=>'fa-industry'],
                ['label'=>'Deadline < 7 Hari','value'=>$pesananDeadlineMendekat,'color'=>'red','icon'=>'fa-exclamation-circle'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 font-medium">
                        {{ $s['label'] }}
                    </p>
                    <p class="text-base font-bold text-gray-800 mt-1">
                        {{ $s['value'] }}
                    </p>
                </div>
                <div class="w-8 h-8 rounded-full bg-{{ $s['color'] }}-100 flex items-center justify-center">
                    <i class="fas {{ $s['icon'] }} text-{{ $s['color'] }}-600 text-base"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="grid grid-cols-1">

        {{-- Line Chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                Tren Pesanan 6 Bulan Terakhir
            </h3>
            <div class="min-h-[280px]">
                <canvas id="trenPesananChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1">

        {{-- Produk Terlaris --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">
                Top 5 Produk Terlaris
            </h3>
            <div class="min-h-[260px]">
                <canvas id="produkTerlarisChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ================= PROGRESS PRODUKSI ================= --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-5">
            Progress Produksi Aktif
        </h3>

        @if($produksiAktif->count())
        <div class="space-y-4">
            @foreach($produksiAktif as $prod)
            @php
                $pesanan = $prod->pesanan;
                $deadline = \Carbon\Carbon::parse($pesanan->deadline);
                $now = now();
                $isOverdue = $now->isAfter($deadline);
                $daysLeft = $isOverdue ? $deadline->diffInDays($now) : $now->diffInDays($deadline);
            @endphp

            <div class="border border-gray-200 rounded-lg p-4 hover:shadow transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800">
                            {{ $pesanan->kode_pesanan }} • {{ $pesanan->jenis_produk }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $pesanan->nama_pemesan }} — {{ $pesanan->jumlah }} pcs
                        </p>
                    </div>

                    <div class="text-right text-xs">
                        @if($isOverdue)
                            <span class="text-red-600 font-semibold">
                                Terlambat {{ (int) $daysLeft }} hari
                            </span>
                        @else
                            <span class="{{ $daysLeft <= 3 ? 'text-red-600' : 'text-gray-600' }}">
                                Deadline {{ (int) $daysLeft }} hari lagi
                            </span>
                        @endif
                        <p class="text-gray-400">{{ $deadline->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-600 w-24">
                        {{ $prod->stage }}
                    </span>

                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full"
                            style="width: {{ $prod->progress_percentage }}%">
                        </div>
                    </div>

                    <span class="text-xs font-semibold text-blue-600 w-10 text-right">
                        {{ $prod->progress_percentage }}%
                    </span>
                </div>

                <p class="text-xs text-gray-400 mt-2">
                    PIC: {{ $prod->pic }}
                </p>
            </div>
            @endforeach
        </div>
        @else
            <p class="text-center text-gray-500 py-8">
                Tidak ada produksi yang sedang berjalan
            </p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data dari Laravel
const trenData = @json($trenPesanan);
const produkData = @json($produkTerlaris);
const statusData = @json($statusPesanan);
const performanceData = @json($onTimeDelivery);

// Nama bulan dalam bahasa Indonesia
const namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

// 1. LINE CHART - Tren Pesanan
const trenLabels = trenData.map(item => namaBulan[item.bulan - 1]);
const trenValues = trenData.map(item => item.total);

new Chart(document.getElementById('trenPesananChart'), {
    type: 'line',
    data: {
        labels: trenLabels,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: trenValues,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

// 2. PIE CHART - Status Pesanan
const statusLabels = statusData.map(item => item.status);
const statusValues = statusData.map(item => item.total);
const statusColors = ['#ef4444', '#3b82f6', '#f59e0b', '#8b5cf6', '#06b6d4', '#10b981'];

new Chart(document.getElementById('statusPesananChart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: statusColors,
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// 3. BAR CHART - Produk Terlaris
const produkLabels = produkData.map(item => item.jenis_produk);
const produkValues = produkData.map(item => item.total_quantity);

new Chart(document.getElementById('produkTerlarisChart'), {
    type: 'bar',
    data: {
        labels: produkLabels,
        datasets: [{
            label: 'Total Quantity',
            data: produkValues,
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

// 4. BAR CHART - Performance
const perfLabels = performanceData.map(item => item.performance);
const perfValues = performanceData.map(item => item.total);

new Chart(document.getElementById('performanceChart'), {
    type: 'bar',
    data: {
        labels: perfLabels,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: perfValues,
            backgroundColor: ['#10b981', '#ef4444'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush