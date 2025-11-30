<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        return view('pasien.pembayaran.index');
    }
}
