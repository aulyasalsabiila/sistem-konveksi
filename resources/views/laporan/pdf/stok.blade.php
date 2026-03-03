<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Bahan Baku</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 10px;
            margin: 20px;
            color: #000000;
            line-height: 1.4;
        }
        
        /* Header */
        .header {
            border-bottom: 3px solid #000000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .company-address {
            font-size: 8px;
            color: #333333;
            margin-bottom: 2px;
        }
        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 15px 0 10px 0;
            text-decoration: underline;
        }
        .report-period {
            text-align: center;
            font-size: 9px;
            color: #333333;
            margin-bottom: 5px;
        }
        
        /* Info Section */
        .info-section {
            border: 1px solid #000000;
            padding: 10px;
            margin-bottom: 15px;
            background: #f9f9f9;
        }
        .info-row {
            display: table;
            width: 100%;
        }
        .info-cell {
            display: table-cell;
            width: 25%;
            font-size: 9px;
            padding: 3px 0;
        }
        .info-section strong {
            font-weight: bold;
        }
        
        /* Summary Section */
        .summary-section {
            border: 2px solid #000000;
            padding: 12px;
            margin-bottom: 15px;
            background: #f5f5f5;
        }
        .summary-title {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 8px 0;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: white;
            border: 1px solid #000000;
        }
        .summary-item .number {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }
        .summary-item .label {
            font-size: 8px;
            color: #333333;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        /* Section Titles */
        .section-title {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 11px;
            font-weight: bold;
            padding: 8px 12px;
            border: 2px solid #000000;
            background: #f5f5f5;
            text-transform: uppercase;
        }
        
        /* Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 2px solid #000000;
        }
        table.data-table th {
            background: #000000;
            color: #ffffff;
            padding: 10px 6px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000000;
        }
        table.data-table td {
            border: 1px solid #333333;
            padding: 8px 6px;
            font-size: 9px;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        table.data-table tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        /* Row Highlights */
        .row-menipis {
            background-color: #e5e5e5 !important;
        }
        .row-habis {
            background-color: #d1d1d1 !important;
        }
        
        /* Nilai Stok Section */
        .nilai-stok-section {
            margin-top: 20px;
            border: 2px solid #000000;
            padding: 12px;
            background: #f9f9f9;
        }
        .nilai-stok-title {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }
        .nilai-stok-table {
            width: 100%;
            border-collapse: collapse;
        }
        .nilai-stok-table td {
            padding: 5px 0;
            font-size: 10px;
            border: none;
        }
        .nilai-stok-table td:first-child {
            width: 40%;
            font-weight: 600;
        }
        .nilai-stok-table td:last-child {
            font-weight: bold;
        }
        
        /* Price History Section */
        .price-history-section {
            margin-top: 25px;
            page-break-before: auto;
        }
        .price-history-header {
            border: 2px solid #000000;
            background: #f5f5f5;
            padding: 12px;
            margin-bottom: 15px;
        }
        .price-history-header h3 {
            font-size: 12px;
            margin-bottom: 3px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .price-history-header p {
            font-size: 9px;
            color: #333333;
        }
        .price-change-item {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #000000;
        }
        .price-change-item h4 {
            font-size: 11px;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .price-change-table {
            width: 100%;
            margin-top: 6px;
            border-collapse: collapse;
            border: 2px solid #000000;
        }
        .price-change-table th {
            background: #000000;
            color: white;
            padding: 6px 5px;
            font-size: 8px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000000;
        }
        .price-change-table td {
            padding: 5px;
            font-size: 8px;
            border: 1px solid #333333;
            background: white;
        }
        .price-old {
            font-weight: normal;
        }
        .price-new {
            font-weight: bold;
        }
        
        /* No Data */
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-style: italic;
            background: #f9f9f9;
            border: 1px dashed #000000;
            margin-top: 10px;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-row {
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 10px;
        }
        .signature-label {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 50px;
        }
        .signature-name {
            font-size: 9px;
            border-top: 1px solid #000000;
            padding-top: 5px;
            display: inline-block;
            min-width: 150px;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #333333;
            border-top: 1px solid #000000;
            padding-top: 10px;
        }
        .footer p {
            margin: 2px 0;
        }
        
        /* Utility Classes */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-small { font-size: 8px; }
    </style>
</head>
<body>
    
    {{-- Header --}}
    <div class="header">
        <div class="company-info">
            <div class="company-name">PUSPITA INDAH KONVEKSI</div>
            <div class="company-address">Jl. Industri No. 123, Surakarta, Jawa Tengah</div>
            <div class="company-address">Telp: (0271) 123-4567 | Email: info@puspitaindah.com</div>
        </div>
    </div>

    {{-- Info Section --}}
    <div class="info-section">
        <div class="info-row">
            <div class="info-cell">
                <strong>Tanggal Cetak</strong> : {{ now()->format('d/m/Y H:i:s') }}
            </div>
            <div class="info-cell">
                <strong>Total Item</strong> : {{ $bahanBakus->count() }} jenis bahan
            </div>
        </div>
    </div>

    {{-- Summary Section --}}
    <div class="summary-section">
        <div class="summary-title">Status Stok</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="number">{{ $stokAman->count() }}</div>
                <div class="label">Stok Aman</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $stokMenurun->count() }}</div>
                <div class="label">Stok Menipis</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $stokHabis->count() }}</div>
                <div class="label">Stok Habis</div>
            </div>
        </div>
    </div>

    {{-- Tabel Stok Aman --}}
    @if($stokAman->count() > 0)
    <div class="section-title">
        STOK AMAN ({{ $stokAman->count() }} item)
    </div>
    <table class="data-table">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Kode</th>
            <th width="23%">Nama Bahan</th>
            <th width="12%">Kategori</th>
            <th width="10%">Stok</th>
            <th width="10%">Min. Stok</th>
            <th width="15%">Harga/Unit</th>
            <th width="15%">Supplier</th>
        </tr>
        @foreach($stokAman as $index => $bahan)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="font-bold">{{ $bahan->kode_bahan }}</td>
            <td>{{ $bahan->nama_bahan }}</td>
            <td class="text-left">{{ $bahan->kategori }}</td>
            <td class="text-center font-bold">{{ $bahan->stok }} {{ $bahan->satuan }}</td>
            <td class="text-center">{{ $bahan->minimum_stok }} {{ $bahan->satuan }}</td>
            <td class="text-right font-bold">Rp {{ number_format($bahan->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-small">{{ $bahan->supplier ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- Tabel Stok Menipis --}}
    @if($stokMenurun->count() > 0)
    <div class="section-title">
        STOK MENIPIS ({{ $stokMenurun->count() }} item)
    </div>
    <table class="data-table">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Kode</th>
            <th width="23%">Nama Bahan</th>
            <th width="12%">Kategori</th>
            <th width="10%">Stok</th>
            <th width="10%">Min. Stok</th>
            <th width="15%">Harga/Unit</th>
            <th width="15%">Supplier</th>
        </tr>
        @foreach($stokMenurun as $index => $bahan)
        <tr class="row-menipis">
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="font-bold">{{ $bahan->kode_bahan }}</td>
            <td>{{ $bahan->nama_bahan }}</td>
            <td class="text-left">{{ $bahan->kategori }}</td>
            <td class="text-center font-bold">{{ $bahan->stok }} {{ $bahan->satuan }}</td>
            <td class="text-center">{{ $bahan->minimum_stok }} {{ $bahan->satuan }}</td>
            <td class="text-right font-bold">Rp {{ number_format($bahan->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-small">{{ $bahan->supplier ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- Tabel Stok Habis --}}
    @if($stokHabis->count() > 0)
    <div class="section-title">
        STOK HABIS ({{ $stokHabis->count() }} item)
    </div>
    <table class="data-table">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Kode</th>
            <th width="23%">Nama Bahan</th>
            <th width="12%">Kategori</th>
            <th width="10%">Stok</th>
            <th width="10%">Min. Stok</th>
            <th width="15%">Harga/Unit</th>
            <th width="15%">Supplier</th>
        </tr>
        @foreach($stokHabis as $index => $bahan)
        <tr class="row-habis">
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="font-bold">{{ $bahan->kode_bahan }}</td>
            <td>{{ $bahan->nama_bahan }}</td>
            <td class="text-left">{{ $bahan->kategori }}</td>
            <td class="text-center font-bold">{{ $bahan->stok }} {{ $bahan->satuan }}</td>
            <td class="text-center">{{ $bahan->minimum_stok }} {{ $bahan->satuan }}</td>
            <td class="text-right font-bold">Rp {{ number_format($bahan->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-small">{{ $bahan->supplier ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- Summary Nilai Stok --}}
    <div class="nilai-stok-section">
        <div class="nilai-stok-title">Nilai Stok</div>
        <table class="nilai-stok-table">
            <tr>
                <td>Total Nilai Stok Keseluruhan</td>
                <td>: Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Jenis Bahan</td>
                <td>: {{ $bahanBakus->count() }} item</td>
            </tr>
        </table>
    </div>

    {{-- Riwayat Perubahan Harga --}}
    @if(isset($priceHistory) && count($priceHistory) > 0)
    <div class="price-history-section">
        <div class="price-history-header">
            <h3>Riwayat Perubahan Harga Bahan Baku</h3>
            <p>Daftar bahan baku yang mengalami perubahan harga</p>
        </div>

        @foreach($priceHistory as $bahanId => $histories)
            @php
                $bahan = $bahanBakus->firstWhere('id', $bahanId);
            @endphp
            @if($bahan)
            <div class="price-change-item">
                <h4>{{ $bahan->kode_bahan }} - {{ $bahan->nama_bahan }} ({{ $bahan->kategori }})</h4>
                <table class="price-change-table">
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Diubah Oleh</th>
                        <th width="20%">Harga Lama</th>
                        <th width="20%">Harga Baru</th>
                        <th width="15%">Stok Lama</th>
                        <th width="15%">Stok Baru</th>
                    </tr>
                    @foreach($histories as $history)
                    <tr>
                        <td class="text-center">{{ $history['tanggal']->format('d/m/Y H:i') }}</td>
                        <td>{{ $history['user'] }}</td>
                        <td class="text-right">
                            @if($history['harga_lama'])
                                <span class="price-old">Rp {{ number_format($history['harga_lama'], 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            @if($history['harga_baru'])
                                <span class="price-new">Rp {{ number_format($history['harga_baru'], 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($history['stok_lama'] !== null)
                                {{ $history['stok_lama'] }} {{ $bahan->satuan }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($history['stok_baru'] !== null)
                                {{ $history['stok_baru'] }} {{ $bahan->satuan }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        @endforeach
    </div>
    @else
    <div class="price-history-section">
        <div class="price-history-header">
            <h3>Riwayat Perubahan Harga Bahan Baku</h3>
            <p>Daftar bahan baku yang mengalami perubahan harga</p>
        </div>
        <div class="no-data">
            Tidak ada perubahan harga bahan baku yang tercatat
        </div>
    </div>
    @endif

    {{-- Signature Section --}}
    <div class="signature-section">
        <div class="signature-row">
            <div class="signature-box">
                <div class="signature-label">Mengetahui,<br>Pimpinan</div>
                <div class="signature-name">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div>
            </div>
            <div class="signature-box">
                <div class="signature-label">Surakarta, {{ now()->format('d F Y') }}<br>Petugas</div>
                <div class="signature-name">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p><strong>PUSPITA INDAH KONVEKSI</strong></p>
        <p>Dokumen ini digenerate otomatis oleh Sistem Informasi Manajemen</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i:s') }}</p>
    </div>
</body>
</html>