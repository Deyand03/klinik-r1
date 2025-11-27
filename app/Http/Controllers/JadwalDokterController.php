<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalDokterController extends Controller
{
    public function index(){
        $token = session('api_token');
        $user = session('user_data');
        $res = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter', [
            'user_id' => $user['id'],
        ]);

        $jadwal_dokter = $res->json()['data'] ?? [];
        return view('admin.jadwal_dokter.index', compact('jadwal_dokter'));
    }
}
