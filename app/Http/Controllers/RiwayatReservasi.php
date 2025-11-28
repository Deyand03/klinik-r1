<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RiwayatReservasi extends Controller
{
    public function index()
    {

        return view('pasien.riwayat_reservasi.index');
    }
}
