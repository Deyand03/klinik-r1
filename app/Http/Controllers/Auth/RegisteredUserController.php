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
        // Validasi Frontend (Opsional tapi bagus buat UX)
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

        // Kirim ke API Backend
        $response = Http::post('http://127.0.0.1:8000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,

            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_domisili' => $request->alamat_domisili,

            // --- TAMBAHAN BARU ---
            'golongan_darah' => $request->golongan_darah ?? '-', // Default strip jika kosong
            'riwayat_alergi' => $request->riwayat_alergi ?? 'Tidak ada', // Default text
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Auto Login
            session([
                'api_token' => $data['access_token'],
                'user_data' => $data['user']
            ]);

            return redirect(route('beranda', absolute: false));
        }



        return back()->withErrors(['email' => 'Registrasi Gagal: ' . ($response->json()['message'] ?? 'Error Server')]);
    }
}
