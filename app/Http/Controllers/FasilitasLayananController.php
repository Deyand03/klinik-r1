<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FasilitasLayananController extends Controller
{
    public function index()
    {
        return view('pasien.fasilitas_layanan.index');
    }

    public function klinik_gigi()
    {
        return view('pasien.fasilitas_layanan.klinik_gigi');
    }

    public function klinik_gizi()
    {
        return view('pasien.fasilitas_layanan.klinik_gizi');
    }

    public function klinik_umum()
    {
        return view('pasien.fasilitas_layanan.klinik_umum');
    }

    public function klinik_mata()
    {
        return view('pasien.fasilitas_layanan.klinik_mata');
    }

    public function klinik_kulit()
    {
        return view('pasien.fasilitas_layanan.klinik_kulit');
    }
}
