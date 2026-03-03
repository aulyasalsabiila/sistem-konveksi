<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        // Group by customer
        $customers = $query->select(
                'nama_pemesan as nama',
                'kontak',
                DB::raw('COUNT(*) as total_pesanan'),
                DB::raw('SUM(total_harga) as total_nilai'),
                DB::raw('MAX(tanggal_pesan) as last_order')
            )
            ->groupBy('nama_pemesan', 'kontak')
            ->orderByDesc('total_nilai')
            ->get();

        return view('customers.index', compact('customers'));
    }

    public function show($nama)
    {
        $customer = Pesanan::where('nama_pemesan', $nama)
            ->select(
                'nama_pemesan as nama',
                'kontak',
                DB::raw('COUNT(*) as total_pesanan'),
                DB::raw('SUM(total_harga) as total_nilai'),
                DB::raw('MAX(tanggal_pesan) as last_order')
            )
            ->groupBy('nama_pemesan', 'kontak')
            ->first();

        $pesanans = Pesanan::where('nama_pemesan', $nama)
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        return view('customers.show', compact('customer', 'pesanans'));
    }

    public function history(Request $request)
    {
        $nama = $request->query('nama');
        
        $pesanans = Pesanan::where('nama_pemesan', $nama)
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        return response()->json($pesanans);
    }
}