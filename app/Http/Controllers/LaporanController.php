<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\BahanBaku;
use App\Models\Produksi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function laporanPesanan(Request $request)
    {
        $query = Pesanan::query();

        // Filter tanggal
        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $query->whereBetween('tanggal_pesan', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pesanans = $query->orderBy('tanggal_pesan', 'desc')->get();

        // Summary
        $totalPesanan = $pesanans->count();
        $totalNilai = $pesanans->sum('total_harga');
        $totalQuantity = $pesanans->sum('jumlah');

        $pdf = PDF::loadView('laporan.pdf.pesanan', compact(
            'pesanans',
            'totalPesanan',
            'totalNilai',
            'totalQuantity',
            'request'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Pesanan_' . date('Y-m-d_His') . '.pdf');
    }

    public function laporanStok()
    {
        $bahanBakus = BahanBaku::orderBy('kategori')->orderBy('nama_bahan')->get();

        $stokAman = $bahanBakus->filter(fn($b) => $b->stok >= $b->minimum_stok);
        $stokMenurun = $bahanBakus->filter(fn($b) => $b->stok < $b->minimum_stok && $b->stok > 0);
        $stokHabis = $bahanBakus->filter(fn($b) => $b->stok <= 0);
        $totalNilaiStok = $bahanBakus->sum(fn($b) => $b->stok * $b->harga_satuan);

        // Get price history untuk setiap bahan baku
        $priceHistory = [];
        foreach ($bahanBakus as $bahan) {
            $history = ActivityLog::where('model', 'BahanBaku')
                ->where('model_id', $bahan->id)
                ->where('action', 'update')
                ->whereNotNull('changes')
                ->orderBy('created_at', 'asc')
                ->get()
                ->filter(function($log) {
                    // Filter hanya yang ada perubahan harga
                    $changes = $log->changes;
                    return isset($changes['old']['harga_satuan']) || 
                           isset($changes['new']['harga_satuan']);
                })
                ->map(function($log) {
                    return [
                        'tanggal' => $log->created_at,
                        'user' => $log->user->name ?? 'System',
                        'harga_lama' => $log->changes['old']['harga_satuan'] ?? null,
                        'harga_baru' => $log->changes['new']['harga_satuan'] ?? null,
                        'stok_lama' => $log->changes['old']['stok'] ?? null,
                        'stok_baru' => $log->changes['new']['stok'] ?? null,
                    ];
                });
            
            if ($history->count() > 0) {
                $priceHistory[$bahan->id] = $history;
            }
        }

        $pdf = PDF::loadView('laporan.pdf.stok', compact(
            'bahanBakus',
            'stokAman',
            'stokMenurun',
            'stokHabis',
            'totalNilaiStok',
            'priceHistory'
        ));

        return $pdf->download('Laporan_Stok_' . date('Y-m-d_His') . '.pdf');
    }

    public function laporanProduksi(Request $request)
    {
        $query = Produksi::with('pesanan');

        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $query->whereBetween('tanggal_mulai', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        $produksis = $query->orderBy('tanggal_mulai', 'desc')->get();

        // Performance metrics
        $totalProduksi = $produksis->count();
        $selesaiTepat = $produksis->filter(function($p) {
            return $p->tanggal_selesai && $p->tanggal_selesai <= $p->pesanan->deadline;
        })->count();
        $terlambat = $produksis->filter(function($p) {
            return $p->tanggal_selesai && $p->tanggal_selesai > $p->pesanan->deadline;
        })->count();

        $pdf = PDF::loadView('laporan.pdf.produksi', compact(
            'produksis',
            'totalProduksi',
            'selesaiTepat',
            'terlambat',
            'request'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Produksi_' . date('Y-m-d_His') . '.pdf');
    }
}