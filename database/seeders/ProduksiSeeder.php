<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produksi;
use App\Models\Pesanan;
use Carbon\Carbon;

class ProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil pesanan yang statusnya bukan Pending
        $pesanans = Pesanan::whereIn('status', [
            'Dikonfirmasi',
            'Proses Produksi',
            'QC',
            'Siap Kirim',
            'Selesai'
        ])->get();

        $stages = ['Persiapan', 'Potong', 'Jahit', 'Finishing', 'QC', 'Packing'];
        $pics = ['Bu Siti', 'Pak Budi', 'Bu Ani', 'Pak Joko', 'Bu Rina', 'Pak Agus'];

        $produksis = [];

        foreach ($pesanans as $pesanan) {
            $tanggalMulai = (clone $pesanan->tanggal_pesan)->addDays(rand(1, 3));
            $estimasiSelesai = (clone $pesanan->deadline)->subDays(2);
            
            // Tentukan stage dan progress berdasarkan status pesanan
            [$stage, $status, $progress] = $this->getStageByStatus($pesanan->status);
            
            $tanggalSelesai = null;
            if ($status === 'Done') {
                $tanggalSelesai = (clone $tanggalMulai)->addDays(rand(7, 20));
            }

            $produksis[] = [
                'pesanan_id' => $pesanan->id,
                'stage' => $stage,
                'status' => $status,
                'pic' => $pics[array_rand($pics)],
                'progress_percentage' => $progress,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'estimasi_selesai' => $estimasiSelesai,
                'catatan' => rand(0, 1) ? 'Proses berjalan lancar' : null,
                'created_at' => $tanggalMulai,
                'updated_at' => now(),
            ];
        }

        foreach ($produksis as $produksi) {
            Produksi::create($produksi);
        }

        $this->command->info('✅ ' . count($produksis) . ' Produksi seeded successfully!');
    }

    private function getStageByStatus($status)
    {
        return match($status) {
            'Dikonfirmasi' => ['Persiapan', 'Progress', 20],
            'Proses Produksi' => [
                ['Potong', 'Jahit', 'Finishing'][array_rand(['Potong', 'Jahit', 'Finishing'])],
                'Progress',
                rand(30, 70)
            ],
            'QC' => ['QC', 'Progress', 90],
            'Siap Kirim' => ['Packing', 'Done', 100],
            'Selesai' => ['Packing', 'Done', 100],
            default => ['Persiapan', 'Pending', 0],
        };
    }
}