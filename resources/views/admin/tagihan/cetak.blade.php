<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Kosan Pak Lalan</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Force print background colors */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            color: #0f172a; 
            line-height: 1.5; 
            padding: 40px; 
            background-color: #fff;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 24px;
            margin-bottom: 28px;
        }
        
        .brand-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 500;
        }

        .report-title {
            text-align: right;
        }

        .report-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .report-date {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
        }

        /* META INFO */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }

        .meta-item span {
            display: block;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .meta-item strong {
            display: block;
            font-size: 13px;
            color: #0f172a;
            font-weight: 700;
            margin-top: 2px;
        }

        /* TABLE */
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-bottom: 24px; 
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        th { 
            background-color: #f8fafc; 
            color: #475569; 
            font-size: 11px; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        td { 
            font-size: 12px; 
            color: #334155;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* STATUS BADGES */
        .badge { 
            display: inline-block;
            padding: 3px 8px; 
            border-radius: 6px;
            font-weight: 700; 
            font-size: 11px;
            text-transform: uppercase;
        }
        .badge-lunas { 
            background-color: #ecfdf5; 
            color: #047857; 
            border: 1px solid #a7f3d0;
        }
        .badge-tunggak { 
            background-color: #fff1f2; 
            color: #be123c; 
            border: 1px solid #fecdd3;
        }

        /* SUMMARY & TOTAL */
        .summary-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .total-box { 
            background-color: #0f172a; 
            color: #fff;
            padding: 18px 24px; 
            border-radius: 12px;
            min-width: 280px;
            text-align: right;
        }

        .total-box span { 
            display: block; 
            font-size: 11px; 
            font-weight: 600; 
            color: #94a3b8; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }

        .total-box strong { 
            display: block;
            font-size: 22px; 
            font-weight: 800;
            color: #10b981;
            margin-top: 4px;
            letter-spacing: -0.5px;
        }

        /* SIGNATURE FOOTER */
        .footer-section {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box { 
            text-align: center;
            width: 200px;
        }

        .ttd-line {
            border-bottom: 1px solid #0f172a;
            margin-top: 70px;
            margin-bottom: 6px;
        }

        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h1 class="brand-title">KOSAN PAK LALAN</h1>
            <p class="brand-subtitle">Sistem Manajemen & Pembukuan Keuangan Hunian</p>
        </div>
        <div class="report-title">
            <span class="report-badge">Laporan Rekapitulasi Kas</span>
            <div class="report-date">Dicetak: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>

    <!-- META INFO -->
    <div class="meta-grid">
        <div class="meta-item">
            <span>Periode Bulan</span>
            <strong>{{ request('bulan') ? request('bulan') : 'Semua Periode' }}</strong>
        </div>
        <div class="meta-item">
            <span>Filter Pencarian</span>
            <strong>{{ request('search') ? request('search') : 'Semua Data Penghuni' }}</strong>
        </div>
        <div class="meta-item">
            <span>Total Tagihan Masuk</span>
            <strong>{{ $tagihans->count() }} Data Transaksi</strong>
        </div>
    </div>

    <!-- TABEL REKAP -->
    <table>
        <thead>
            <tr>
                <th class="text-center" width="6%">No</th>
                <th width="26%">Nama Penghuni</th>
                <th width="16%">Unit Kamar</th>
                <th width="20%">Periode Tagihan</th>
                <th class="text-right" width="18%">Nominal</th>
                <th class="text-center" width="14%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tagihans as $index => $t)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $t->penghuni->nama ?? 'Penghuni Telah Dihapus' }}</strong></td>
                <td>{{ $t->penghuni && $t->penghuni->kamar ? 'Kamar ' . $t->penghuni->kamar->nomor_kamar : 'Kosong' }}</td>
                <td>{{ $t->bulan_tagihan }}</td>
                <td class="text-right" style="font-weight: 700;">Rp {{ number_format($t->jumlah_bayar, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($t->status == 'Lunas')
                        <span class="badge badge-lunas">Lunas</span>
                    @else
                        <span class="badge badge-tunggak">{{ $t->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 36px; color: #94a3b8;">
                    Tidak ada data tagihan yang sesuai dengan filter.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTAL KAS -->
    <div class="summary-wrapper">
        <div class="total-box">
            <span>Total Pemasukan Kas (Lunas)</span>
            <strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <div class="footer-section">
        <div class="ttd-box">
            <span style="font-size: 11px; color: #64748b;">Mengetahui,</span>
            <div class="ttd-line"></div>
            <strong style="font-size: 12px; color: #0f172a;">Pengelola Kosan Lalan</strong>
        </div>
    </div>

</body>
</html>