<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }

    /**
     * * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar di Frontend
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'nik' => 'required|numeric|digits:16',
            'no_hp' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat_domisili' => 'required',
        ]);

        // 2. Kirim ke Backend (UBAH DISINI: Tambah withHeaders)
        $response = Http::withHeaders([
            'Accept' => 'application/json', // PENTING: Agar backend kirim JSON error, bukan redirect
        ])->post(env('API_URL') . '/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_domisili' => $request->alamat_domisili,
            'golongan_darah' => $request->golongan_darah ?? '-',
            'riwayat_alergi' => $request->riwayat_alergi ?? 'Tidak ada',
        ]);

        // 3. Jika Sukses
        if ($response->successful()) {
            $data = $response->json();
            session([
                'api_token' => $data['access_token'],
                'user_data' => $data['user']
            ]);
            return redirect(route('beranda', absolute: false))->with('success', 'Registrasi berhasil!');
        }

        // 4. Jika Error Validasi (Status 422) - UBAH DISINI
        if ($response->status() === 422) {
            // Ambil array pesan error dari backend (yang sudah Bahasa Indonesia tadi)
            $errors = $response->json()['errors'] ?? [];
            // Kirim kembali ke form register agar muncul tulisan merah
            return back()->withErrors($errors)->withInput();
        }

        // 5. Error Lainnya (Server Error)
        return back()
            ->withErrors(['email' => 'Terjadi kesalahan: ' . ($response->json()['message'] ?? 'Gagal menghubungi server.')])
            ->withInput();
    }
}
