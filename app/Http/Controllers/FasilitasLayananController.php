<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FasilitasLayananController extends Controller
{
    public function index(){
        return view('pasien.fasilitas_layanan.index');
    }
}
