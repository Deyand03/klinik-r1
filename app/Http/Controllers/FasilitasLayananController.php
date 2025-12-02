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

    public function layanansatu(){
        return view('pasien.fasilitas_layanan.ambulans');
    }

    public function layanandua(){
        return view('pasien.fasilitas_layanan.periksa_mata');
    }

    public function layanantiga(){
        return view('pasien.fasilitas_layanan.periksa_gigi');
    }

    public function layananempat(){
        return view('pasien.fasilitas_layanan.mikrodermabrasi');
    }
    
    public function fasilitassatu(){
        return view('pasien.fasilitas_layanan.tunggu');
    }

    public function fasilitasdua(){
        return view('pasien.fasilitas_layanan.laboratorium');
    }

    public function fasilitastiga(){
        return view('pasien.fasilitas_layanan.tindakan');
    }

    public function fasilitasempat(){
        return view('pasien.fasilitas_layanan.farmasi');
    }
}
