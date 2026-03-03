<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\BahanBaku;
use App\Models\Produksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Data
        $totalPesananBulanIni = Pesanan::whereMonth('tanggal_pesan', Carbon::now()->month)
            ->whereYear('tanggal_pesan', Carbon::now()->year)
            ->count();

        $totalRevenueBulanIni = Pesanan::whereMonth('tanggal_pesan', Carbon::now()->month)
            ->whereYear('tanggal_pesan', Carbon::now()->year)
            ->sum('total_harga');

        $pesananProses = Pesanan::where('status', 'Proses Produksi')->count();

        $pesananDeadlineMendekat = Pesanan::where('deadline', '<=', Carbon::now()->addDays(7))
            ->where('status', '!=', 'Selesai')
            ->count();

        // Data untuk Chart - Tren Pesanan 6 Bulan Terakhir
        $trenPesanan = Pesanan::select(
                DB::raw('MONTH(tanggal_pesan) as bulan'),
                DB::raw('YEAR(tanggal_pesan) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_pesan', '>=', Carbon::now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Data untuk Chart - Produk Terlaris
        $produkTerlaris = Pesanan::select(
                'jenis_produk',
                DB::raw('SUM(jumlah) as total_quantity')
            )
            ->groupBy('jenis_produk')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Data untuk Chart - Status Pesanan
        $statusPesanan = Pesanan::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        // Data untuk Chart - Performance
        $onTimeDelivery = DB::table('pesanans')
            ->join('produksis', 'produksis.pesanan_id', '=', 'pesanans.id')
            ->selectRaw("
                CASE 
                    WHEN produksis.tanggal_selesai <= pesanans.deadline 
                    THEN 'Tepat Waktu'
                    ELSE 'Terlambat'
                END as performance,
                COUNT(*) as total
            ")
            ->whereNotNull('produksis.tanggal_selesai')
            ->groupBy('performance')
            ->get();

        // Alert Stok Menipis
        $stokMenurun = BahanBaku::stokMenurun()->get();

        // Progress Produksi Aktif
        $produksiAktif = Produksi::with('pesanan')
            ->aktif()
            ->orderBy('estimasi_selesai')
            ->get();

        return view('dashboard.index', compact(
            'totalPesananBulanIni',
            'totalRevenueBulanIni',
            'pesananProses',
            'pesananDeadlineMendekat',
            'trenPesanan',
            'produkTerlaris',
            'statusPesanan',
            'onTimeDelivery',
            'stokMenurun',
            'produksiAktif'
        ));
    }
}