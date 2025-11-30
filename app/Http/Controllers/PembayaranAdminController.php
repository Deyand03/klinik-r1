<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranAdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pembayaran.index');
    }
}
