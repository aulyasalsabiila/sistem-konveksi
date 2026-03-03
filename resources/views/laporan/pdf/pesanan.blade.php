<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan</title>
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
        
        /* Info Box */
        .info-section {
            border: 1px solid #000000;
            padding: 10px;
            margin-bottom: 15px;
            background: #f9f9f9;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            display: table-cell;
            width: 25%;
            font-weight: bold;
            font-size: 9px;
        }
        .info-value {
            display: table-cell;
            font-size: 9px;
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
        
        /* Status Text - Plain */
        .status-text {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        /* Utility Classes */
        .summary-section {
            margin-top: 20px;
            border: 2px solid #000000;
            padding: 12px;
            background: #f9f9f9;
        }
        .summary-title {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 5px 0;
            font-size: 10px;
            border: none;
        }
        .summary-table td:first-child {
            width: 40%;
            font-weight: 600;
        }
        .summary-table td:last-child {
            font-weight: bold;
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
        
        /* Utility Classes */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-small { font-size: 8px; }
        .uppercase { text-transform: uppercase; }
    </style>
</head>
<body>
    
    {{-- Header --}}
    <div class="header">
        <div class="company-info">
            <div class="company-name">PUSPITA INDAH KONVEKSI</div>
            <div class="company-address">Jl. Industri No. 123, Surakarta, Jawa Tengah</div>
            <div class="company-address">Telp: (0271) 123-4567 | Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="aec7c0c8c1eededbdddec7dacfc7c0cacfc680cdc1c3">[email&#160;protected]</a></div>
        </div>
    </div>

    {{-- Info Section --}}
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Tanggal Cetak : {{ now()->format('d/m/Y H:i:s') }}</div>
            <div class="info-label">Total Pesanan : {{ $totalPesanan }} pesanan</div>
        </div>
        @if($request->status)
        <div class="info-row">
            <div class="info-label">Filter Status:</div>
            <div class="info-value" colspan="3">{{ $request->status }}</div>
        </div>
        @endif
    </div>

    {{-- Tabel Pesanan --}}
    <table class="data-table">
        <tr>
            <th width="4%" class="text-center">No</th>
            <th width="11%">Kode Pesanan</th>
            <th width="16%">Pemesan</th>
            <th width="14%">Produk</th>
            <th width="7%" class="text-left">Qty</th>
            <th width="14%" class="text-right">Total Harga</th>
            <th width="10%" class="text-center">Tgl Pesan</th>
            <th width="10%" class="text-center">Deadline</th>
            <th width="14%" class="text-center">Status</th>
        </tr>
        @forelse($pesanans as $index => $pesanan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold">{{ $pesanan->kode_pesanan }}</td>
                <td>
                    <div class="font-bold">{{ $pesanan->nama_pemesan }}</div>
                    <div class="text-small">{{ $pesanan->kontak }}</div>
                </td>
                <td>{{ $pesanan->jenis_produk }}</td>
                <td class="text-left font-bold">{{ $pesanan->jumlah }} pcs</td>
                <td class="text-right font-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                <td class="text-center text-small">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}</td>
                <td class="text-center text-small">{{ \Carbon\Carbon::parse($pesanan->deadline)->format('d/m/Y') }}</td>
                <td class="text-left">
                    <span class="status-text">{{ $pesanan->status }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 25px; color: #666666;">
                    Tidak ada data pesanan untuk ditampilkan
                </td>
            </tr>
        @endforelse
    </table>

    {{-- Summary --}}
    <div class="summary-section">
        <div class="summary-title">Ringkasan Laporan</div>
        <table class="summary-table">
            <tr>
                <td>Total Pesanan</td>
                <td>: {{ $totalPesanan }} pesanan</td>
            </tr>
            <tr>
                <td>Total Quantity</td>
                <td>: {{ $totalQuantity }} pcs</td>
            </tr>
            <tr>
                <td>Total Nilai</td>
                <td>: Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

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
        <p>Dokumen ini digenerate otomatis oleh