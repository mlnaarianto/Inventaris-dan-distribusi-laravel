<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok</title>
    <style>
        @page { margin: 28mm 15mm 22mm 15mm; }
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1e293b; line-height: 1.45; }

        header { position: fixed; top: -20mm; left: 0; right: 0; }
        footer { position: fixed; bottom: -14mm; left: 0; right: 0; font-size: 9px; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 5px; }
        .pagenum:before { content: counter(page); }

        table { width: 100%; border-collapse: collapse; }
        td, th { vertical-align: top; }

        .kop td { padding: 0; }
        .kop-nama { font-size: 17px; font-weight: bold; color: #1d4ed8; letter-spacing: 0.5px; }
        .kop-sub { font-size: 9.5px; color: #475569; }
        .kop-judul { font-size: 18px; font-weight: bold; color: #94a3b8; text-align: right; letter-spacing: 1px; }
        .kop-nomor { text-align: right; font-size: 10px; font-weight: bold; }
        .garis { border-top: 3px solid #1d4ed8; margin: 6px 0 14px; }

        .info td { padding: 2px 0; }
        .info .lbl { width: 95px; color: #64748b; }

        .ringkas { margin-top: 12px; }
        .ringkas td { width: 33.33%; border: 1px solid #94a3b8; padding: 7px 10px; }
        .ringkas .jdl { font-size: 8.5px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; }
        .ringkas .nilai { font-size: 15px; font-weight: bold; }

        .item { margin-top: 14px; }
        .item th { background: #e2e8f0; border: 1px solid #94a3b8; padding: 6px 5px; font-size: 9px; text-transform: uppercase; }
        .item td { border: 1px solid #94a3b8; padding: 5px; }
        .item tr { page-break-inside: avoid; }
        .item tfoot td { background: #f1f5f9; font-weight: bold; }

        .tengah { text-align: center; }
        .kanan { text-align: right; }
        .masuk { color: #047857; font-weight: bold; }
        .keluar { color: #be123c; font-weight: bold; }

        .ttd { margin-top: 26px; page-break-inside: avoid; }
        .ttd td { width: 50%; text-align: center; padding: 0 8px; }
        .ttd .ruang { height: 62px; }
        .ttd .garis-ttd { border-bottom: 1px solid #000; margin: 0 40px 3px; height: 1px; }
    </style>
</head>
<body>
    @php
        $periode = match (true) {
            $dari && $sampai => \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') . ' s/d ' . \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y'),
            (bool) $dari     => 'Sejak ' . \Carbon\Carbon::parse($dari)->translatedFormat('d F Y'),
            (bool) $sampai   => 'Sampai ' . \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y'),
            default          => 'Semua periode',
        };
        $jenisLabel = $jenis ? ucfirst($jenis) : 'Masuk & Keluar';
    @endphp

    <header>
        <table class="kop">
            <tr>
                <td>
                    <div class="kop-nama">PT. AMERTA INDAH OTSUKA</div>
                    <div class="kop-sub">Gudang Pusat Distribusi Pocari Sweat Indonesia</div>
                    <div class="kop-sub">Jl. Siliwangi Km 28, Sukabumi, Jawa Barat</div>
                </td>
                <td>
                    <div class="kop-judul">LAPORAN MUTASI STOK</div>
                    <div class="kop-nomor">{{ $periode }}</div>
                </td>
            </tr>
        </table>
        <div class="garis"></div>
    </header>

    <footer>
        <table>
            <tr>
                <td>Dokumen ini dicetak otomatis oleh Pocari System pada {{ now()->format('d/m/Y H:i') }} WIB.</td>
                <td class="kanan">Halaman <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <main>
        <table class="info">
            <tr><td class="lbl">Periode</td><td>: {{ $periode }}</td></tr>
            <tr><td class="lbl">Jenis Mutasi</td><td>: {{ $jenisLabel }}</td></tr>
            <tr><td class="lbl">Tanggal Cetak</td><td>: {{ now()->translatedFormat('d F Y, H:i') }} WIB</td></tr>
            <tr><td class="lbl">Dicetak oleh</td><td>: {{ $pencetak }}</td></tr>
        </table>

        <table class="ringkas">
            <tr>
                <td><div class="jdl">Total Transaksi</div><div class="nilai">{{ number_format($mutasi->count(), 0, ',', '.') }}</div></td>
                <td><div class="jdl">Total Masuk</div><div class="nilai masuk">+ {{ number_format($totalMasuk, 0, ',', '.') }}</div></td>
                <td><div class="jdl">Total Keluar</div><div class="nilai keluar">- {{ number_format($totalKeluar, 0, ',', '.') }}</div></td>
            </tr>
        </table>

        <table class="item">
            <thead>
                <tr>
                    <th style="width: 26px;">No</th>
                    <th style="width: 85px;">Waktu</th>
                    <th style="width: 55px;">Jenis</th>
                    <th>Nama Produk</th>
                    <th style="width: 50px;">Qty</th>
                    <th style="width: 150px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mutasi as $i => $item)
                    @php $masuk = strtolower($item->jenis_mutasi) === 'masuk'; @endphp
                    <tr>
                        <td class="tengah">{{ $i + 1 }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}<br>
                            <span style="color:#64748b;">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</span>
                        </td>
                        <td class="tengah {{ $masuk ? 'masuk' : 'keluar' }}">{{ $masuk ? 'MASUK' : 'KELUAR' }}</td>
                        <td>
                            <strong>{{ $item->product?->nama_barang ?? 'Produk Dihapus' }}</strong><br>
                            <span style="color:#64748b;">{{ $item->product?->ukuran ?? '-' }} | {{ strtoupper($item->product?->satuan ?? '-') }}</span>
                        </td>
                        <td class="tengah {{ $masuk ? 'masuk' : 'keluar' }}">{{ $masuk ? '+' : '-' }} {{ number_format($item->qty, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="tengah" style="padding: 18px;">Tidak ada data mutasi pada periode ini.</td></tr>
                @endforelse
            </tbody>
            @if ($mutasi->isNotEmpty())
                <tfoot>
                    <tr>
                        <td colspan="4" class="kanan">Selisih (masuk - keluar)</td>
                        <td class="tengah">{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>

        <table class="ttd">
            <tr>
                <td>Dibuat oleh,</td>
                <td>Mengetahui, Kepala Gudang</td>
            </tr>
            <tr><td class="ruang"></td><td class="ruang"></td></tr>
            <tr>
                <td><div class="garis-ttd"></div><strong>{{ $pencetak }}</strong></td>
                <td><div class="garis-ttd"></div>(..............................)</td>
            </tr>
        </table>
    </main>
</body>
</html>