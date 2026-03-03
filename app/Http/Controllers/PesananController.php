<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Pesanan::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('jenis_produk', 'like', "%{$search}%");
            });
        }

        // Filter Status
        $query->byStatus($request->status);

        $pesanans = $query->latest()->paginate(15);

        return view('pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        return view('pesanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'kontak' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_produk' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'ukuran' => 'required|string',
            'warna' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'tanggal_pesan' => 'required|date',
            'deadline' => 'required|date|after:tanggal_pesan',
            'harga_per_pcs' => 'required|numeric|min:0',
            'dp' => 'nullable|numeric|min:0',
            'foto_desain' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Calculate total harga
        $validated['total_harga'] = $validated['harga_per_pcs'] * $validated['jumlah'];
        $validated['dp'] = $validated['dp'] ?? 0;
        $validated['sisa_pembayaran'] = $validated['total_harga'] - $validated['dp'];

        // Upload foto desain
        if ($request->hasFile('foto_desain')) {
            $validated['foto_desain'] = $request->file('foto_desain')
                ->store('desain-pesanan', 'public');
        }

        $pesanan = Pesanan::create($validated);

        // Log activity
        self::logActivity(
            'create',
            'Pesanan',
            $pesanan->id,
            'Menambahkan pesanan baru: ' . $pesanan->kode_pesanan
        );

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function show(Pesanan $pesanan)
    {
        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('pesanan.edit', compact('pesanan'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'kontak' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_produk' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'ukuran' => 'required|string',
            'warna' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'tanggal_pesan' => 'required|date',
            'deadline' => 'required|date|after:tanggal_pesan',
            'harga_per_pcs' => 'required|numeric|min:0',
            'dp' => 'nullable|numeric|min:0',
            'status' => 'required|in:Pending,Dikonfirmasi,Proses Produksi,QC,Siap Kirim,Selesai',
            'foto_desain' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Recalculate
        $validated['total_harga'] = $validated['harga_per_pcs'] * $validated['jumlah'];
        $validated['dp'] = $validated['dp'] ?? 0;
        $validated['sisa_pembayaran'] = $validated['total_harga'] - $validated['dp'];

        // Upload foto desain baru
        if ($request->hasFile('foto_desain')) {
            // Hapus foto lama
            if ($pesanan->foto_desain) {
                Storage::disk('public')->delete($pesanan->foto_desain);
            }
            $validated['foto_desain'] = $request->file('foto_desain')
                ->store('desain-pesanan', 'public');
        }

        // Simpan data lama untuk log
        $oldData = [
            'nama_pemesan' => $pesanan->nama_pemesan,
            'status' => $pesanan->status,
            'total_harga' => $pesanan->total_harga
        ];

        $pesanan->update($validated);

        // Log activity
        self::logActivity(
            'update',
            'Pesanan',
            $pesanan->id,
            'Mengupdate pesanan: ' . $pesanan->kode_pesanan,
            [
                'old' => $oldData,
                'new' => [
                    'nama_pemesan' => $pesanan->nama_pemesan,
                    'status' => $pesanan->status,
                    'total_harga' => $pesanan->total_harga
                ]
            ]
        );

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diupdate!');
    }

    public function destroy(Pesanan $pesanan)
    {
        $kodePesanan = $pesanan->kode_pesanan;

        // Log activity sebelum delete
        self::logActivity(
            'delete',
            'Pesanan',
            $pesanan->id,
            'Menghapus pesanan: ' . $kodePesanan
        );

        // Hapus foto desain
        if ($pesanan->foto_desain) {
            Storage::disk('public')->delete($pesanan->foto_desain);
        }

        $pesanan->delete();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}