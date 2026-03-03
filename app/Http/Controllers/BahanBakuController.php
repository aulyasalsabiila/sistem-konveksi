<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    use LogsActivity;

    /**
     * Tampilkan daftar bahan baku
     */
    public function index(Request $request)
    {
        $query = BahanBaku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_bahan', 'like', "%{$search}%")
                  ->orWhere('nama_bahan', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $bahanBakus = $query
            ->orderBy('kategori')
            ->orderBy('nama_bahan')
            ->paginate(15);

        $stokMenurunCount = BahanBaku::whereColumn('stok', '<', 'minimum_stok')
            ->where('stok', '>', 0)
            ->count();

        return view('bahan-baku.index', compact(
            'bahanBakus',
            'stokMenurunCount'
        ));
    }

    public function create()
    {
        return view('bahan-baku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bahan'       => 'required|string|max:255',
            'kategori'         => 'required|in:Kain,Aksesoris,Sablon,Kemasan',
            'stok'             => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'minimum_stok'     => 'required|numeric|min:0',
            'harga_satuan'     => 'required|numeric|min:0',
            'supplier'         => 'nullable|string|max:255',
            'kontak_supplier'  => 'nullable|string|max:20',
        ]);

        $bahanBaku = BahanBaku::create($validated);

        self::logActivity(
            'create',
            'BahanBaku',
            $bahanBaku->id,
            'Menambahkan bahan baku: ' . $bahanBaku->nama_bahan
        );

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function edit(BahanBaku $bahanBaku)
    {
        return view('bahan-baku.edit', compact('bahanBaku'));
    }

    public function ajaxEdit(BahanBaku $bahanBaku)
    {
        return response()->json($bahanBaku);
    }

    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $validated = $request->validate([
            'nama_bahan'       => 'required|string|max:255',
            'kategori'         => 'required|in:Kain,Aksesoris,Sablon,Kemasan',
            'stok'             => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'minimum_stok'     => 'required|numeric|min:0',
            'harga_satuan'     => 'required|numeric|min:0',
            'supplier'         => 'nullable|string|max:255',
            'kontak_supplier'  => 'nullable|string|max:20',
        ]);

        $bahanBaku->update($validated);

        self::logActivity(
            'update',
            'BahanBaku',
            $bahanBaku->id,
            'Mengupdate bahan baku: ' . $bahanBaku->nama_bahan
        );

        return redirect()
            ->back()
            ->with('success', 'Bahan baku berhasil diupdate!');
    }

    public function destroy(BahanBaku $bahanBaku)
    {
        $bahanBaku->delete();

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil dihapus!');
    }

    public function restock(Request $request, BahanBaku $bahanBaku)
    {
        $request->validate([
            'jumlah_restock' => 'required|numeric|min:1'
        ]);

        $bahanBaku->stok += $request->jumlah_restock;
        $bahanBaku->save();

        self::logActivity(
            'update',
            'BahanBaku',
            $bahanBaku->id,
            'Restock bahan baku sebanyak ' . $request->jumlah_restock
        );

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Stok berhasil direstock');
    }

    public function restockForm(BahanBaku $bahanBaku)
    {
        return view('bahan-baku.restock', compact('bahanBaku'));
    }
}