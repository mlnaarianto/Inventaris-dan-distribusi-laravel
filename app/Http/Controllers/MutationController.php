<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MutationController extends Controller
{
    /**
     * Halaman riwayat mutasi (tabel DataTables di layar).
     */
    public function index(): View
    {
        $mutasi = StockMutation::with('product')
            ->latest()
            ->get();

        return view('mutasi.index', compact('mutasi'));
    }

    /**
     * Laporan mutasi dalam bentuk PDF.
     * - Tanpa parameter 'unduh': tampil di browser (bisa langsung dicetak).
     * - Dengan 'unduh=1': langsung terunduh sebagai file.
     * Filter opsional: dari, sampai, jenis (masuk/keluar).
     */
    public function cetak(Request $request)
    {
        $data = $request->validate([
            'dari'   => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'jenis'  => ['nullable', 'in:masuk,keluar'],
        ], [], [
            'dari'   => 'tanggal awal',
            'sampai' => 'tanggal akhir',
            'jenis'  => 'jenis mutasi',
        ]);

        $mutasi = StockMutation::with('product')
            ->when($data['dari'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($data['sampai'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($data['jenis'] ?? null, fn ($q, $v) => $q->whereRaw('LOWER(jenis_mutasi) = ?', [$v]))
            ->orderBy('created_at')
            ->get();

        $isMasuk = fn ($m) => strtolower($m->jenis_mutasi) === 'masuk';

        $pdf = Pdf::loadView('mutasi.cetak', [
            'mutasi'      => $mutasi,
            'dari'        => $data['dari'] ?? null,
            'sampai'      => $data['sampai'] ?? null,
            'jenis'       => $data['jenis'] ?? null,
            'totalMasuk'  => $mutasi->filter($isMasuk)->sum('qty'),
            'totalKeluar' => $mutasi->reject($isMasuk)->sum('qty'),
            'pencetak'    => $request->user()->name,
        ])->setPaper('a4', 'portrait');

        $nama = 'laporan-mutasi-' . now()->format('Ymd-His') . '.pdf';

        return $request->boolean('unduh')
            ? $pdf->download($nama)
            : $pdf->stream($nama);
    }
}