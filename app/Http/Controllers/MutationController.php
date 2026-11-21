<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;

class MutationController extends Controller
{
    public function index()
    {
        $mutasi = StockMutation::with('product')->orderBy('created_at', 'desc')->get();
        return view('mutasi.index', compact('mutasi'));
    }
}