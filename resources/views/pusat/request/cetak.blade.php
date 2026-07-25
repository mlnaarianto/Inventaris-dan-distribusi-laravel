<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $pengajuan->kode_request }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background: white; }
            @page { size: A4; margin: 20mm; }
            .no-print { display: none !important; }
        }
        body { font-family: 'Times New Roman', Times, serif; color: #000; }
    </style>
</head>
<body class="bg-gray-100 flex justify-center py-10 print:py-0 print:bg-white">

    <div class="bg-white w-[210mm] min-h-[297mm] shadow-lg print:shadow-none p-10 relative">

        <button onclick="window.print()" class="no-print absolute top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-sans font-bold shadow-md hover:bg-blue-700">
            Cetak Dokumen
        </button>

        <div class="border-b-4 border-black pb-4 mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-blue-800 print:text-black">PT. AMERTA INDAH OTSUKA</h1>
                <p class="text-sm">Gudang Pusat Distribusi Pocari Sweat Indonesia</p>
                <p class="text-sm">Jl. Siliwangi Km 28, Sukabumi, Jawa Barat</p>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-black uppercase tracking-widest text-gray-400">SURAT JALAN</h2>
            </div>
        </div>

        <div class="flex justify-between mb-8 text-sm">
            <div>
                <table class="leading-relaxed">
                    <tr><td class="pr-4 font-bold">No. Referensi</td><td>: {{ $pengajuan->kode_request }}</td></tr>
                    <tr><td class="pr-4 font-bold">Tanggal Cetak</td><td>: {{ \Carbon\Carbon::now()->format('d F Y') }}</td></tr>
                    <tr><td class="pr-4 font-bold">Tanggal Order</td><td>: {{ \Carbon\Carbon::parse($pengajuan->tanggal_request)->format('d F Y') }}</td></tr>
                </table>
            </div>
            <div class="w-1/2 border border-black p-3 rounded-lg">
                <p class="font-bold border-b border-black pb-1 mb-1">Dikirim Kepada / Tujuan:</p>
                <p class="font-bold text-lg uppercase">
                    {{ $pengajuan->user?->name ?? 'DISTRIBUTOR TIDAK AKTIF' }}
                </p>
                <p class="text-xs mt-1">Cabang Distributor Resmi Pocari Sweat</p>
            </div>
        </div>

        <p class="text-sm mb-4">Bersama surat ini, kami kirimkan barang-barang di bawah ini dengan kendaraan perusahaan dalam keadaan baik dan utuh:</p>

        <table class="w-full text-sm border-collapse border border-black mb-8">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-black p-2 w-10 text-center">NO</th>
                    <th class="border border-black p-2 text-left">NAMA PRODUK</th>
                    <th class="border border-black p-2 text-center w-32">KEMASAN</th>
                    <th class="border border-black p-2 text-center w-24">QTY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan->details as $index => $detail)
                <tr>
                    <td class="border border-black p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-black p-2 font-bold">{{ $detail->product->nama_barang }}</td>
                    <td class="border border-black p-2 text-center">{{ $detail->product->ukuran }}</td>
                    <td class="border border-black p-2 text-center font-bold">{{ $detail->qty_diminta }} {{ $detail->product->satuan }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="border border-black p-2 text-right font-bold">TOTAL KUANTITAS KESELURUHAN :</td>
                    <td class="border border-black p-2 text-center font-bold text-lg">{{ $pengajuan->details->sum('qty_diminta') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-xs mb-10 italic">
            * Catatan: Barang yang sudah diterima dan ditandatangani tidak dapat dikembalikan tanpa persetujuan khusus.
        </div>

        <div class="flex justify-between text-center text-sm px-10">
            <div>
                <p class="mb-16">Penerima Barang,</p>
                <p class="font-bold border-b border-black pb-1 w-40 mx-auto">
                    ({{ $pengajuan->user?->name ?? '...................................' }})
                </p>
                <p class="text-xs mt-1">Distributor</p>
            </div>
            <div>
                <p class="mb-16">Mengetahui/Gudang,</p>
                <p class="font-bold border-b border-black pb-1 w-40 mx-auto">(...................................)</p>
                <p class="text-xs mt-1">Admin Pusat</p>
            </div>
            <div>
                <p class="mb-16">Pengemudi / Supir,</p>
                <p class="font-bold border-b border-black pb-1 w-40 mx-auto">(...................................)</p>
                <p class="text-xs mt-1">Logistik</p>
            </div>
        </div>

    </div>

</body>
</html>
