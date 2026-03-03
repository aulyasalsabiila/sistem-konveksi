<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use Carbon\Carbon;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['nama' => 'PT. Maju Jaya Sentosa', 'kontak' => '081234567890'],
            ['nama' => 'CV. Berkah Abadi', 'kontak' => '081298765432'],
            ['nama' => 'SD Negara 1 Sleman', 'kontak' => '081223344556'],
            ['nama' => 'SMP Negeri 2 Yogyakarta', 'kontak' => '081234569999'],
            ['nama' => 'Komunitas Sepeda Gowes Jogja', 'kontak' => '081298887766'],
            ['nama' => 'Toko Oleh-Oleh Merapi', 'kontak' => '081334455667'],
            ['nama' => 'PT. Teknologi Nusantara', 'kontak' => '081445566778'],
            ['nama' => 'Yayasan Pendidikan Harapan', 'kontak' => '081556677889'],
            ['nama' => 'Cafe Kopi Kenangan', 'kontak' => '081667788990'],
            ['nama' => 'Restoran Padang Sederhana', 'kontak' => '081778899001'],
        ];

        $produk = [
            'Kaos',
            'Polo',
            'Seragam Sekolah',
            'Jaket',
            'Hoodie',
            'Jersey Custom',
            'Kemeja',
            'Kaos Souvenir',
        ];

        $status = ['Pending', 'Dikonfirmasi', 'Proses Produksi', 'QC', 'Siap Kirim', 'Selesai'];

        // Generate 25 pesanan dengan berbagai status dan tanggal
        for ($i = 1; $i <= 25; $i++) {
            $customer = $customers[array_rand($customers)];
            $jenisProduk = $produk[array_rand($produk)];
            $jumlah = rand(50, 500);
            $hargaPerPcs = rand(40000, 120000);
            $totalHarga = $jumlah * $hargaPerPcs;
            $dp = $totalHarga * (rand(0, 1) ? 0.5 : 1); // 50% DP atau lunas
            
            // Tanggal pesan: 3 bulan terakhir
            $tanggalPesan = Carbon::now()->subDays(rand(0, 90));
            $deadline = (clone $tanggalPesan)->addDays(rand(7, 30));
            
            $pesananStatus = $status[array_rand($status)];

            // PENTING: Hapus 'kode_pesanan' dari data, biar Model yang auto-generate
            Pesanan::create([
                'nama_pemesan' => $customer['nama'],
                'kontak' => $customer['kontak'],
                'alamat' => 'Jl. Contoh No. ' . rand(1, 100) . ', Yogyakarta',
                'jenis_produk' => $jenisProduk,
                'jumlah' => $jumlah,
                'ukuran' => $this->generateUkuran($jumlah),
                'warna' => $this->generateWarna(),
                'spesifikasi' => 'Bahan: Cotton Combed 30s, Sablon: Depan & Belakang',
                'tanggal_pesan' => $tanggalPesan,
                'deadline' => $deadline,
                'harga_per_pcs' => $hargaPerPcs,
                'total_harga' => $totalHarga,
                'dp' => $dp,
                'sisa_pembayaran' => $totalHarga - $dp,
                'status' => $pesananStatus,
                'keterangan' => rand(0, 1) ? 'Pesanan urgent, mohon diprioritaskan' : null,
                // 'created_at' dan 'updated_at' akan otomatis di-set Laravel
            ]);
        }

        $this->command->info('✅ 25 Pesanan seeded successfully!');
    }

    private function generateUkuran($total)
    {
        $s = round($total * 0.2);
        $m = round($total * 0.3);
        $l = round($total * 0.3);
        $xl = round($total * 0.15);
        $xxl = $total - ($s + $m + $l + $xl);

        return "S($s), M($m), L($l), XL($xl), XXL($xxl)";
    }

    private function generateWarna()
    {
        $warna = ['Hitam', 'Putih', 'Navy', 'Merah', 'Biru', 'Hijau', 'Abu-abu'];
        $count = rand(1, 2);
        $selected = array_rand(array_flip($warna), $count);
        
        return is_array($selected) ? implode(', ', $selected) : $selected;
    }
}