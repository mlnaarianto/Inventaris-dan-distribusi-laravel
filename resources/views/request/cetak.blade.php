<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan - {{ $pengajuan->kode_request }}</title>
    <style>
        @page { margin: 28mm 18mm 22mm 18mm; }
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5px; color: #1e293b; line-height: 1.45; }

        header { position: fixed; top: -20mm; left: 0; right: 0; }
        footer { position: fixed; bottom: -14mm; left: 0; right: 0; font-size: 9px; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 5px; }
        .pagenum:before { content: counter(page); }

        table { width: 100%; border-collapse: collapse; }
        td, th { vertical-align: top; }

        .kop td { padding: 0; }
        .kop-nama { font-size: 17px; font-weight: bold; color: #1d4ed8; letter-spacing: 0.5px; }
        .kop-sub { font-size: 9.5px; color: #475569; }
        .kop-judul { font-size: 22px; font-weight: bold; color: #94a3b8; text-align: right; letter-spacing: 2px; }
        .kop-nomor { text-align: right; font-size: 11px; font-weight: bold; }
        .garis { border-top: 3px solid #1d4ed8; margin: 6px 0 14px; }

        .info td { padding: 2px 0; }
        .info .lbl { width: 95px; color: #64748b; }
        .kotak { border: 1px solid #94a3b8; padding: 8px 10px; }
        .kotak-judul { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 3px; }
        .kotak-nama { font-size: 14px; font-weight: bold; text-transform: uppercase; }

        .badge { display: inline-block; padding: 2px 8px; border: 1px solid #94a3b8; font-size: 9px; font-weight: bold; text-transform: uppercase; }

        .item { margin-top: 14px; }
        .item th { background: #e2e8f0; border: 1px solid #94a3b8; padding: 6px 5px; font-size: 9.5px; text-transform: uppercase; }
        .item td { border: 1px solid #94a3b8; padding: 6px 5px; }
        .item tr { page-break-inside: avoid; }
        .item tfoot td { background: #f1f5f9; font-weight: bold; }

        .tengah { text-align: center; }
        .kanan { text-align: right; }

        .catatan { margin-top: 14px; font-size: 9.5px; color: #475569; }
        .catatan ol { margin: 3px 0 0 16px; padding: 0; }

        .ttd { margin-top: 26px; page-break-inside: avoid; }
        .ttd td { width: 33.33%; text-align: center; padding: 0 8px; }
        .ttd .ruang { height: 62px; }
        .ttd .garis-ttd { border-bottom: 1px solid #000; margin: 0 14px 3px; height: 1px; }
        .ttd .peran { font-size: 9px; color: #64748b; }
    </style>
</head>
<body>
    @php
        $nomorSurat = str_replace('REQ-', 'SJ-', $pengajuan->kode_request);
        $totalJenis = $pengajuan->details->count();
        $totalQty   = $pengajuan->details->sum('qty_diminta');
        $statusLabel = [
            'diproses' => 'Siap Kirim',
            'dikirim'  => 'Dalam Pengiriman',
            'selesai'  => 'Sudah Diterima',
        ][$pengajuan->status] ?? ucfirst($pengajuan->status);
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
                    <div class="kop-judul">SURAT JALAN</div>
                    <div class="kop-nomor">No. {{ $nomorSurat }}</div>
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
        {{-- Informasi dokumen & tujuan --}}
        <table>
            <tr>
                <td style="width: 52%; padding-right: 14px;">
                    <table class="info">
                        <tr><td class="lbl">No. Surat Jalan</td><td>: <strong>{{ $nomorSurat }}</strong></td></tr>
                        <tr><td class="lbl">Ref. Order</td><td>: {{ $pengajuan->kode_request }}</td></tr>
                        <tr><td class="lbl">Tanggal Order</td><td>: {{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->translatedFormat('d F Y, H:i') }} WIB</td></tr>
                        <tr><td class="lbl">Tanggal Cetak</td><td>: {{ now()->translatedFormat('d F Y, H:i') }} WIB</td></tr>
                        <tr><td class="lbl">Status Order</td><td>: <span class="badge">{{ $statusLabel }}</span></td></tr>
                    </table>
                </td>
                <td style="width: 48%;">
                    <div class="kotak">
                        <div class="kotak-judul">Dikirim kepada</div>
                        <div class="kotak-nama">{{ $pengajuan->user?->name ?? 'Distributor Tidak Aktif' }}</div>
                        @if ($pengajuan->user?->email)
                            <div class="kop-sub" style="margin-top: 2px;">{{ $pengajuan->user->email }}</div>
                        @endif
                        <div class="kop-sub" style="margin-top: 2px;">Distributor Resmi Pocari Sweat</div>
                    </div>
                </td>
            </tr>
        </table>

        <p style="margin: 14px 0 0;">
            Bersama surat ini kami kirimkan barang-barang berikut dengan kendaraan perusahaan dalam keadaan baik dan utuh:
        </p>

        {{-- Daftar barang --}}
        <table class="item">
            <thead>
                <tr>
                    <th style="width: 28px;">No</th>
                    <th>Nama Produk</th>
                    <th style="width: 70px;">Ukuran</th>
                    <th style="width: 70px;">Satuan</th>
                    <th style="width: 60px;">Qty</th>
                    <th style="width: 70px;">Cek Terima</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan->details as $i => $detail)
                    <tr>
                        <td class="tengah">{{ $i + 1 }}</td>
                        <td><strong>{{ $detail->product?->nama_barang ?? 'Produk Dihapus' }}</strong></td>
                        <td class="tengah">{{ $detail->product?->ukuran ?? '-' }}</td>
                        <td class="tengah">{{ strtoupper($detail->product?->satuan ?? '-') }}</td>
                        <td class="tengah"><strong>{{ number_format($detail->qty_diminta, 0, ',', '.') }}</strong></td>
                        <td class="tengah">&#9744;</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="kanan">Total ({{ $totalJenis }} jenis barang)</td>
                    <td class="tengah">{{ number_format($totalQty, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- Catatan --}}
        <div class="catatan">
            <strong>Catatan:</strong>
            <ol>
                <li>Periksa jumlah dan kondisi barang saat diterima, lalu beri tanda pada kolom "Cek Terima".</li>
                <li>Klaim kekurangan atau kerusakan wajib dicatat pada surat jalan ini sebelum penerima menandatangani.</li>
                <li>Barang yang sudah diterima dan ditandatangani tidak dapat dikembalikan tanpa persetujuan Pusat.</li>
            </ol>
        </div>

        {{-- Tanda tangan --}}
        <table class="ttd">
            <tr>
                <td>Penerima Barang,</td>
                <td>Pengemudi / Logistik,</td>
                <td>Mengetahui, Admin Gudang</td>
            </tr>
            <tr>
                <td class="ruang"></td><td class="ruang"></td><td class="ruang"></td>
            </tr>
            <tr>
                <td><div class="garis-ttd"></div><strong>{{ $pengajuan->user?->name ?? '..............................' }}</strong></td>
                <td><div class="garis-ttd"></div>(..............................)</td>
                <td><div class="garis-ttd"></div>(..............................)</td>
            </tr>
            <tr>
                <td class="peran">Distributor</td>
                <td class="peran">Tanggal: ____ / ____ / ________</td>
                <td class="peran">Pusat</td>
            </tr>
        </table>
    </main>
</body>
</html>