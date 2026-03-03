<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Pesanan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Produksi::with('pesanan');

        // Search - FIXED
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('pesanan', function($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pemesan', 'like', "%{$search}%");
            });
        }

        // Filter Stage
        if ($request->has('stage') && $request->stage != '') {
            $query->where('stage', $request->stage);
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $produksis = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $totalProduksi = Produksi::count();
        $produksiProgress = Produksi::where('status', 'Progress')->count();
        $produksiSelesai = Produksi::where('status', 'Done')->count();
        $produksiAktif = Produksi::where('status', '!=', 'Done')->count();
        
        $avgProgress = Produksi::avg('progress_percentage') ?? 0;
        $avgProgress = round($avgProgress);

        return view('produksi.index', compact(
            'produksis',
            'totalProduksi',
            'produksiProgress',
            'produksiSelesai',
            'produksiAktif',
            'avgProgress'
        ));
    }

    public function timeline(Request $request)
    {
        $produksis = Produksi::with('pesanan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('produksi.timeline', compact('produksis'));
    }

    public function create()
    {
        $pesanans = Pesanan::where('status', 'Dikonfirmasi')
            ->whereDoesntHave('produksi')
            ->get();

        return view('produksi.create', compact('pesanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'stage' => 'required|in:Persiapan,Potong,Jahit,Finishing,QC,Packing',
            'status' => 'required|in:Pending,Progress,Done',
            'pic' => 'nullable|string|max:255',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'tanggal_mulai' => 'nullable|date',
            'estimasi_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan' => 'nullable|string'
        ]);

        $produksi = Produksi::create($validated);

        // Update status pesanan
        $pesanan = Pesanan::find($request->pesanan_id);
        $pesanan->update(['status' => 'Proses Produksi']);

        // Log activity
        self::logActivity(
            'create',
            'Produksi',
            $produksi->id,
            'Memulai produksi untuk pesanan: ' . $pesanan->kode_pesanan . ' (Tahap: ' . $produksi->stage . ')'
        );

        return redirect()->route('produksi.index')
            ->with('success', 'Data produksi berhasil ditambahkan!');
    }

    public function show(Produksi $produksi)
    {
        $produksi->load('pesanan');
        return view('produksi.show', compact('produksi'));
    }

    public function edit(Produksi $produksi)
    {
        return view('produksi.edit', compact('produksi'));
    }

    public function update(Request $request, Produksi $produksi)
    {
        $validated = $request->validate([
            'stage' => 'required|in:Persiapan,Potong,Jahit,Finishing,QC,Packing',
            'status' => 'required|in:Pending,Progress,Done',
            'pic' => 'nullable|string|max:255',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'estimasi_selesai' => 'nullable|date',
            'catatan' => 'nullable|string'
        ]);

        // Simpan data lama untuk log
        $oldData = [
            'stage' => $produksi->stage,
            'status' => $produksi->status,
            'progress_percentage' => $produksi->progress_percentage
        ];

        // Auto-set tanggal_selesai when status is Done
        if ($request->status === 'Done' && !$request->tanggal_selesai) {
            $validated['tanggal_selesai'] = now();
            $validated['progress_percentage'] = 100;
        }

        $produksi->update($validated);

        // Update status pesanan
        if ($request->status === 'Done') {
            $produksi->pesanan->update(['status' => 'Selesai']);
        } elseif ($request->stage === 'QC') {
            $produksi->pesanan->update(['status' => 'QC']);
        } else {
            $produksi->pesanan->update(['status' => 'Proses Produksi']);
        }

        // Log activity
        $description = 'Mengupdate produksi ' . $produksi->pesanan->kode_pesanan;
        if ($oldData['stage'] != $produksi->stage) {
            $description .= ' - Tahap: ' . $oldData['stage'] . ' → ' . $produksi->stage;
        }
        if ($oldData['progress_percentage'] != $produksi->progress_percentage) {
            $description .= ' - Progress: ' . $oldData['progress_percentage'] . '% → ' . $produksi->progress_percentage . '%';
        }
        if ($request->status === 'Done') {
            $description .= ' - STATUS: SELESAI ✓';
        }

        self::logActivity(
            'update',
            'Produksi',
            $produksi->id,
            $description,
            [
                'old' => $oldData,
                'new' => [
                    'stage' => $produksi->stage,
                    'status' => $produksi->status,
                    'progress_percentage' => $produksi->progress_percentage
                ]
            ]
        );

        return redirect()->route('produksi.index')
            ->with('success', 'Progress produksi berhasil diupdate!');
    }

    public function destroy(Produksi $produksi)
    {
        $kodePesanan = $produksi->pesanan->kode_pesanan;

        // Log activity sebelum delete
        self::logActivity(
            'delete',
            'Produksi',
            $produksi->id,
            'Menghapus data produksi untuk pesanan: ' . $kodePesanan
        );

        $produksi->delete();

        return redirect()->route('produksi.index')
            ->with('success', 'Data produksi berhasil dihapus!');
    }

    public function updateStage(Request $request, Produksi $produksi)
    {
        $validated = $request->validate([
            'stage' => 'required|in:Persiapan,Potong,Jahit,Finishing,QC,Packing',
        ]);

        $oldStage = $produksi->stage;
        $produksi->update($validated);

        // Log activity
        self::logActivity(
            'update',
            'Produksi',
            $produksi->id,
            'Mengubah tahap produksi ' . $produksi->pesanan->kode_pesanan . ': ' . $oldStage . ' → ' . $validated['stage']
        );

        return back()->with('success', 'Tahap produksi berhasil diupdate!');
    }

    public function updateProgress(Request $request, Produksi $produksi)
    {
        $validated = $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $oldProgress = $produksi->progress_percentage;
        $produksi->update($validated);

        // Auto update status based on progress
        if ($validated['progress_percentage'] == 0) {
            $produksi->update(['status' => 'Pending']);
        } elseif ($validated['progress_percentage'] == 100) {
            $produksi->update(['status' => 'Done', 'tanggal_selesai' => now()]);
        } else {
            $produksi->update(['status' => 'Progress']);
        }

        // Log activity
        $description = 'Mengupdate progress produksi ' . $produksi->pesanan->kode_pesanan . ': ' . $oldProgress . '% → ' . $validated['progress_percentage'] . '%';
        if ($validated['progress_percentage'] == 100) {
            $description .= ' - SELESAI ✓';
        }

        self::logActivity(
            'update',
            'Produksi',
            $produksi->id,
            $description
        );

        return back()->with('success', 'Progress berhasil diupdate!');
    }
}