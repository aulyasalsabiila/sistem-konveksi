<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanBakus = [
            // KAIN
            [
                'nama_bahan' => 'Cotton Combed 20s',
                'kategori' => 'Kain',
                'stok' => 180,
                'satuan' => 'meter',
                'minimum_stok' => 100,
                'harga_satuan' => 30000,
                'supplier' => 'Toko Kain Jaya',
                'kontak_supplier' => '081234567890',
            ],
            [
                'nama_bahan' => 'Cotton Combed 24s',
                'kategori' => 'Kain',
                'stok' => 220,
                'satuan' => 'meter',
                'minimum_stok' => 150,
                'harga_satuan' => 32000,
                'supplier' => 'Toko Kain Jaya',
                'kontak_supplier' => '081234567890',
            ],
            [
                'nama_bahan' => 'Cotton Combed 30s',
                'kategori' => 'Kain',
                'stok' => 250,
                'satuan' => 'meter',
                'minimum_stok' => 200,
                'harga_satuan' => 35000,
                'supplier' => 'Toko Kain Jaya',
                'kontak_supplier' => '081234567890',
            ],
            [
                'nama_bahan' => 'Polyester PE',
                'kategori' => 'Kain',
                'stok' => 45,
                'satuan' => 'meter',
                'minimum_stok' => 80,
                'harga_satuan' => 28000,
                'supplier' => 'Toko Kain Jaya',
                'kontak_supplier' => '081234567890',
            ],
            [
                'nama_bahan' => 'TC (Teteron Cotton)',
                'kategori' => 'Kain',
                'stok' => 120,
                'satuan' => 'meter',
                'minimum_stok' => 100,
                'harga_satuan' => 33000,
                'supplier' => 'CV Textile Mandiri',
                'kontak_supplier' => '081298765432',
            ],
            [
                'nama_bahan' => 'Baby Terry',
                'kategori' => 'Kain',
                'stok' => 85,
                'satuan' => 'meter',
                'minimum_stok' => 50,
                'harga_satuan' => 40000,
                'supplier' => 'CV Textile Mandiri',
                'kontak_supplier' => '081298765432',
            ],
            [
                'nama_bahan' => 'Fleece',
                'kategori' => 'Kain',
                'stok' => 60,
                'satuan' => 'meter',
                'minimum_stok' => 50,
                'harga_satuan' => 45000,
                'supplier' => 'CV Textile Mandiri',
                'kontak_supplier' => '081298765432',
            ],

            // AKSESORIS
            [
                'nama_bahan' => 'Benang Hitam',
                'kategori' => 'Aksesoris',
                'stok' => 45,
                'satuan' => 'cone',
                'minimum_stok' => 50,
                'harga_satuan' => 25000,
                'supplier' => 'UD Benang Makmur',
                'kontak_supplier' => '081223344556',
            ],
            [
                'nama_bahan' => 'Benang Putih',
                'kategori' => 'Aksesoris',
                'stok' => 60,
                'satuan' => 'cone',
                'minimum_stok' => 50,
                'harga_satuan' => 25000,
                'supplier' => 'UD Benang Makmur',
                'kontak_supplier' => '081223344556',
            ],
            [
                'nama_bahan' => 'Benang Warna (Mix)',
                'kategori' => 'Aksesoris',
                'stok' => 120,
                'satuan' => 'cone',
                'minimum_stok' => 100,
                'harga_satuan' => 27000,
                'supplier' => 'UD Benang Makmur',
                'kontak_supplier' => '081223344556',
            ],
            [
                'nama_bahan' => 'Kancing Baju',
                'kategori' => 'Aksesoris',
                'stok' => 2500,
                'satuan' => 'pcs',
                'minimum_stok' => 1000,
                'harga_satuan' => 500,
                'supplier' => 'Toko Aksesoris Lengkap',
                'kontak_supplier' => '081234569999',
            ],
            [
                'nama_bahan' => 'Resleting 20cm',
                'kategori' => 'Aksesoris',
                'stok' => 300,
                'satuan' => 'pcs',
                'minimum_stok' => 200,
                'harga_satuan' => 3000,
                'supplier' => 'Toko Aksesoris Lengkap',
                'kontak_supplier' => '081234569999',
            ],
            [
                'nama_bahan' => 'Resleting 30cm',
                'kategori' => 'Aksesoris',
                'stok' => 180,
                'satuan' => 'pcs',
                'minimum_stok' => 150,
                'harga_satuan' => 4000,
                'supplier' => 'Toko Aksesoris Lengkap',
                'kontak_supplier' => '081234569999',
            ],
            [
                'nama_bahan' => 'Karet Pinggang',
                'kategori' => 'Aksesoris',
                'stok' => 80,
                'satuan' => 'meter',
                'minimum_stok' => 50,
                'harga_satuan' => 8000,
                'supplier' => 'Toko Aksesoris Lengkap',
                'kontak_supplier' => '081234569999',
            ],
            [
                'nama_bahan' => 'Label Brand',
                'kategori' => 'Aksesoris',
                'stok' => 150,
                'satuan' => 'pcs',
                'minimum_stok' => 200,
                'harga_satuan' => 2000,
                'supplier' => 'Printing Label Express',
                'kontak_supplier' => '081298887766',
            ],

            // SABLON & BORDIR
            [
                'nama_bahan' => 'Tinta Sablon Hitam',
                'kategori' => 'Sablon',
                'stok' => 8,
                'satuan' => 'kg',
                'minimum_stok' => 10,
                'harga_satuan' => 120000,
                'supplier' => 'Sablon Express',
                'kontak_supplier' => '081334455667',
            ],
            [
                'nama_bahan' => 'Tinta Sablon Putih',
                'kategori' => 'Sablon',
                'stok' => 12,
                'satuan' => 'kg',
                'minimum_stok' => 10,
                'harga_satuan' => 120000,
                'supplier' => 'Sablon Express',
                'kontak_supplier' => '081334455667',
            ],
            [
                'nama_bahan' => 'Tinta Sablon Warna',
                'kategori' => 'Sablon',
                'stok' => 15,
                'satuan' => 'kg',
                'minimum_stok' => 15,
                'harga_satuan' => 130000,
                'supplier' => 'Sablon Express',
                'kontak_supplier' => '081334455667',
            ],
            [
                'nama_bahan' => 'Screen Sablon',
                'kategori' => 'Sablon',
                'stok' => 25,
                'satuan' => 'pcs',
                'minimum_stok' => 20,
                'harga_satuan' => 50000,
                'supplier' => 'Sablon Express',
                'kontak_supplier' => '081334455667',
            ],
            [
                'nama_bahan' => 'Benang Bordir',
                'kategori' => 'Sablon',
                'stok' => 80,
                'satuan' => 'cone',
                'minimum_stok' => 50,
                'harga_satuan' => 35000,
                'supplier' => 'Bordir Sejahtera',
                'kontak_supplier' => '081445566778',
            ],

            // KEMASAN
            [
                'nama_bahan' => 'Plastik OPP',
                'kategori' => 'Kemasan',
                'stok' => 500,
                'satuan' => 'lembar',
                'minimum_stok' => 300,
                'harga_satuan' => 500,
                'supplier' => 'Toko Kemasan Indo',
                'kontak_supplier' => '081556677889',
            ],
            [
                'nama_bahan' => 'Karton Box Ukuran S',
                'kategori' => 'Kemasan',
                'stok' => 100,
                'satuan' => 'pcs',
                'minimum_stok' => 50,
                'harga_satuan' => 5000,
                'supplier' => 'Toko Kemasan Indo',
                'kontak_supplier' => '081556677889',
            ],
            [
                'nama_bahan' => 'Karton Box Ukuran M',
                'kategori' => 'Kemasan',
                'stok' => 80,
                'satuan' => 'pcs',
                'minimum_stok' => 50,
                'harga_satuan' => 7000,
                'supplier' => 'Toko Kemasan Indo',
                'kontak_supplier' => '081556677889',
            ],
            [
                'nama_bahan' => 'Sticker Label',
                'kategori' => 'Kemasan',
                'stok' => 350,
                'satuan' => 'lembar',
                'minimum_stok' => 200,
                'harga_satuan' => 1000,
                'supplier' => 'Printing Label Express',
                'kontak_supplier' => '081298887766',
            ],
        ];

        foreach ($bahanBakus as $bahan) {
            BahanBaku::create($bahan);
        }

        $this->command->info('✅ ' . count($bahanBakus) . ' Bahan Baku seeded successfully!');
    }
}