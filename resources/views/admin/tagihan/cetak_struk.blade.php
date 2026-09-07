<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - #INV-{{ date('Ym') }}-{{ str_pad($tagihan->id, 3, '0', STR_PAD_LEFT) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style id="print-style">
        @media print {
            @page { size: A5 portrait; margin: 10mm; }
        }
    </style>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef2f6;
            color: #334155;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Action Bar Component */
        .action-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .printer-select {
            padding: 8px 12px;
            font-size: 13px;
            font-family: inherit;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            background-color: #f8fafc;
            color: #0f172a;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-print {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print:hover {
            background-color: #1e293b;
        }

        /* Default Card Standard Layout */
        .kwitansi-card {
            background: #ffffff;
            width: 540px;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 2px solid #f1f5f9;
        }

        .brand-logo h2 { font-size: 18px; font-weight: 700; color: #0f172a; }
        .brand-logo p { font-size: 11px; color: #64748b; margin-top: 2px; }
        .badge-title { font-size: 15px; font-weight: 700; color: #1e293b; text-transform: uppercase; }
        .invoice-no { font-size: 11px; color: #64748b; font-weight: 500; margin-top: 2px; }

        .content { margin: 20px 0; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table tr { border-bottom: 1px dashed #e2e8f0; }
        .info-table tr:last-child { border-bottom: none; }
        .info-table td { padding: 10px 0; font-size: 12.5px; vertical-align: top; }
        .label-col { width: 140px; color: #64748b; font-weight: 500; }
        .value-col { color: #0f172a; font-weight: 600; }

        .terbilang-box {
            background-color: #f8fafc;
            border-left: 3px solid #0f172a;
            padding: 8px 12px;
            border-radius: 0 4px 4px 0;
            font-style: italic;
            color: #334155;
            font-weight: 500;
            font-size: 12px;
            margin-top: 6px;
        }

        .footer {
            margin-top: 24px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .nominal-box {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .nominal-label { font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: 600; }
        .nominal-value { font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px; }
        .status-stamp {
            display: inline-block;
            margin-top: 5px;
            padding: 2px 6px;
            background-color: #dcfce7;
            color: #15803d;
            font-size: 10px;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .ttd-box { text-align: center; width: 160px; }
        .ttd-date { font-size: 11.5px; color: #64748b; margin-bottom: 40px; }
        .ttd-name { font-size: 12.5px; font-weight: 700; color: #0f172a; border-top: 1px solid #94a3b8; padding-top: 4px; }

        /* Thermal Overrides (Aktif Pas Pilih Mode Thermal) */
        .kwitansi-card.mode-thermal {
            width: 320px;
            padding: 16px;
            border-radius: 8px;
        }
        .mode-thermal .header { flex-direction: column; text-align: center; gap: 6px; }
        .mode-thermal .kwitansi-badge { text-align: center; }
        .mode-thermal .info-table td { font-size: 11px; padding: 5px 0; }
        .mode-thermal .label-col { width: 100px; }
        .mode-thermal .footer { flex-direction: column; align-items: stretch; gap: 12px; }
        .mode-thermal .ttd-box { width: 100%; text-align: right; }
        .mode-thermal .ttd-date { margin-bottom: 24px; }

        /* Base Print Mode Rules */
        @media print {
            body { background-color: #ffffff; padding: 0; }
            .action-bar { display: none; }
            .kwitansi-card { box-shadow: none; border: 1px solid #94a3b8; width: 100%; padding: 20px; border-radius: 0; }
            .kwitansi-card.mode-thermal { border: none; padding: 8px; }
        }
    </style>
</head>
<body>

    @php
        // Ambil tanggal pembayaran atau waktu buat tagihan
        $tglBayar = \Carbon\Carbon::parse($tagihan->tanggal_bayar ?? $tagihan->created_at);
    @endphp

    <div class="wrapper">
        <div class="action-bar">
            <select id="printMode" class="printer-select" onchange="switchPrinterMode()">
                <option value="standard">🖨️ Printer Biasa (A4/A5)</option>
                <option value="thermal">🧾 Printer Thermal (80mm)</option>
            </select>
            <button class="btn-print" onclick="window.print()">Cetak</button>
        </div>

        <div class="kwitansi-card" id="kwitansiCard">
            <div class="header">
                <div class="brand-logo">
                    <h2>KOSAN LALAN</h2>
                    <p>Portal Admin Keuangan & Operational</p>
                </div>
                <div class="kwitansi-badge">
                    <div class="badge-title">Kwitansi</div>
                    <div class="invoice-no">#INV-{{ date('Ym') }}-{{ str_pad($tagihan->id, 3, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>

            <div class="content">
                <table class="info-table">
                    <tr>
                        <td class="label-col">Telah Diterima Dari</td>
                        <td class="value-col">: {{ $tagihan->penghuni->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Uang Sejumlah</td>
                        <td class="value-col">: Rp {{ number_format($tagihan->jumlah_bayar, 0, ',', '.') }},-
                            <div class="terbilang-box">
                                Terbilang: {{ trim($terbilang) }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Untuk Pembayaran</td>
                        <td class="value-col">: Sewa Kosan 
                            @if($tagihan->penghuni && $tagihan->penghuni->kamars->count() > 0)
                                {{ $tagihan->penghuni->kamars->map(function($k) {
                                    return (Str::startsWith(strtolower(trim($k->nomor_kamar)), 'kamar') ? trim($k->nomor_kamar) : 'Kamar ' . trim($k->nomor_kamar)) . ($k->tipe_kamar == 'VIP' ? ' (VIP)' : '');
                                })->join(', ') }}
                            @else
                                -
                            @endif
                            — Periode: {{ $tagihan->bulan_tagihan }}
                            @if($tagihan->catatan)
                                <br><small class="text-slate-500">Catatan: {{ $tagihan->catatan }}</small>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <div class="nominal-wrapper">
                    <div class="nominal-box">
                        <div class="nominal-label">Total Pembayaran</div>
                        <div class="nominal-value">Rp {{ number_format($tagihan->jumlah_bayar, 0, ',', '.') }},-</div>
                    </div>
                    <div class="status-stamp">LUNAS</div>
                </div>

                <div class="ttd-box">
                    <div class="ttd-date">
                        Garut, {{ $tglBayar->translatedFormat('d F Y') }}
                    </div>
                    <div class="ttd-name">
                        Pak Lalan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchPrinterMode() {
            const mode = document.getElementById('printMode').value;
            const card = document.getElementById('kwitansiCard');
            const printStyle = document.getElementById('print-style');

            if (mode === 'thermal') {
                card.classList.add('mode-thermal');
                printStyle.innerHTML = '@media print { @page { size: 80mm auto; margin: 0; } }';
            } else {
                card.classList.remove('mode-thermal');
                printStyle.innerHTML = '@media print { @page { size: A5 portrait; margin: 10mm; } }';
            }
        }
    </script>
</body>
</html>