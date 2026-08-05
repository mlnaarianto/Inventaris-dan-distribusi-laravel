<?php

namespace App\Http\Controllers\Pusat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class StockPredictionController extends Controller
{
    // Menampilkan halaman form prediksi
    public function index()
    {
        return view('pusat.prediksi.index');
    }

    // Memproses data dan mengirim request ke FastAPI
    public function predict(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8003/predict', [
            'product_id' => (int) $request->product_id,
            'bulan' => (int) $request->bulan,
            'hari_dalam_minggu' => (int) $request->hari_dalam_minggu,
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return view('pusat.prediksi.index', ['prediction' => $result['predicted_qty']]);
        }

        return back()->with('error', 'Gagal terhubung ke layanan AI.');
    }
}