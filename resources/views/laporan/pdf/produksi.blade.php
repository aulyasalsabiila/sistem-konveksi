<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produksi</title>
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
            width: 50%;
            font-size: 9px;
            padding: 3px 0;
        }
        .info-section strong {
            font-weight: bold;
        }
        
        /* Performance Metrics */
        .performance-section {
            border: 2px solid #000000;
            padding: 12px;
            margin-bottom: 15px;
            background: #f5f5f5;
        }
        .performance-title {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }
        .performance-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 8px 0;
        }
        .performance-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: white;
            border: 1px solid #000000;
        }
        .performance-item .number {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }
        .performance-item .label {
            font-size: 8px;
            color: #333333;
            font-weight: 600;
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
        
        /* Stage/Status Text - Plain */
        .stage-text {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        /* Progress Bar */
        .progress-container {
            position: relative;
        }
        .progress-bar {
            width: 70%;
            height: 10px;
            background: #e5e5e5;
            border: 1px solid #000000;
            display: inline-block;
            vertical-align: middle;
        }
        .progress-fill {
            height: 100%;
            background: #666666;
        }
        .progress-fill.complete {
            background: #000000;
        }
        .progress-text {
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            margin-left: 4px;
            vertical-align: middle;
        }
        
        /* Notes Row */
        .notes-row {
            background: #eeeeee !important;
            border-left: 3px solid #000000 !important;
        }
        .notes-row td {
            padding: 6px !important;
            font-size: 8px !important;
            font-style: italic;
        }
        
        /* Stage Breakdown */
        .stage-breakdown {
            margin-top: 20px;
            border: 2px solid #000000;
            padding: 12px;
            background: #f9f9f9;
        }
        .stage-breakdown-title {
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }
        .stage-breakdown table {
            width: 100%;
            border-collapse: collapse;
        }
        .stage-breakdown td {
            padding: 5px 0;
            font-size: 10px;
            border: none;
        }
        .stage-breakdown td:first-child {
            width: 40%;
            font-weight: 600;
        }
        .stage-breakdown td:last-child {
            font-weight: bold;
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
            <div class="company-address">Telp: (0271) 123-4567 | Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d2bbbcb4bd92a2a7a1a2bba6b3bbbcb6b3bafcb1bdbf">[email&#160;protected]</a></div>
        </div>
    </div>

    {{-- Info Section --}}
    <div class="info-section">
        <div class="info-row">
            <div class="info-cell">
                <strong>Tanggal Cetak</strong> : {{ now()->format('d/m/Y H:i:s') }}
            </div>
            <div class="info-cell">
                <strong>Total Data</strong> : {{ $totalProduksi ?? 0 }} produksi
            </div>
        </div>
    </div>

    {{-- Performance Metrics --}}
    <div class="performance-section">
        <div class="performance-title">Performance Metrics</div>
        <div class="performance-grid">
            <div class="performance-item">
                <div class="number">{{ $totalProduksi ?? 0 }}</div>
                <div class="label">Total Produksi</div>
            </div>
            <div class="performance-item">
                <div class="number">{{ $selesaiTepat ?? 0 }}</div>
                <div class="label">Tepat Waktu</div>
            </div>
            <div class="performance-item">
                <div class="number">{{ $terlambat ?? 0 }}</div>
                <div class="label">Terlambat</div>
            </div>
            @if(isset($totalProduksi) && $totalProduksi > 0)
            <div class="performance-item">
                <div class="number">{{ round((($selesaiTepat ?? 0) / $totalProduksi) * 100, 1) }} %</div>
                <div class="label">OTD Rate</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Data Table --}}
    <table class="data-table">
        <tr>
            <th width="4%" class="text-center">No</th>
            <th width="11%">Kode Pesanan</th>
            <th width="14%">Produk</th>
            <th width="11%">Pemesan</th>
            <th width="10%" class="text-center">Tahap</th>
            <th width="8%" class="text-center">Status</th>
            <th width="8%">PIC</th>
            <th width="8%" class="text-center">Progress</th>
            <th width="10%" class="text-center">Mulai</th>
            <th width="10%" class="text-center">Target</th>
        </tr>
        
        @forelse($produksis ?? [] as $index => $produksi)
            @php
                $pesanan = $produksi->pesanan ?? null;
                $isLate = $produksi->tanggal_selesai && $pesanan && $produksi->tanggal_selesai > $pesanan->deadline;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold">{{ $pesanan->kode_pesanan ?? '-' }}</td>
                <td>{{ $pesanan->jenis_produk ?? '-' }}</td>
                <td class="text-small">{{ $pesanan->nama_pemesan ?? '-' }}</td>
                <td class="text-left">
                    <span class="stage-text">{{ $produksi->stage ?? '-' }}</span>
                </td>
                <td class="text-left">
                    <span class="stage-text">{{ $produksi->status ?? '-' }}</span>
                </td>
                <td class="text-small">{{ $produksi->pic ?? '-' }}</td>
                <td class="text-right">
                    <div class="progress-container">
                        <span class="progress-text">{{ $produksi->progress_percentage ?? 0 }}%</span>
                    </div>
                </td>
                <td class="text-center text-small">
                    {{ $produksi->tanggal_mulai ? \Carbon\Carbon::parse($produksi->tanggal_mulai)->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center text-small">
                    @if($produksi->tanggal_selesai ?? false)
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($produksi->tanggal_selesai)->format('d/m/Y') }}
                            @if($isLate) ⚠ @endif
                        </span>
                    @else
                        {{ isset($produksi->estimasi_selesai) ? \Carbon\Carbon::parse($produksi->estimasi_selesai)->format('d/m/Y') : '-' }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 25px; color: #666666;">
                    Tidak ada data produksi untuk ditampilkan
                </td>
            </tr>
        @endforelse
    </table>

    {{-- Stage Breakdown --}}
    @if(isset($totalProduksi) && $totalProduksi > 0 && isset($produksis))
    <div class="stage-breakdown">
        <div class="stage-breakdown-title">Breakdown by Stage</div>
        <table>
            @php
                $stages = ['Persiapan', 'Potong', 'Jahit', 'Finishing', 'QC', 'Packing'];
            @endphp
            @foreach($stages as $stage)
                @php
                    $count = $produksis->where('stage', $stage)->count();
                @endphp
                @if($count > 0)
                <tr>
                    <td>{{ $stage }}</td>
                    <td>: {{ $count }} pesanan</td>
                </tr>
                @endif
            @endforeach
        </table>
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
        <p>Dokumen ini digenerate otomatis oleh