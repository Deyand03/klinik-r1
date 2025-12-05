<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class RegisterPasienController extends Controller
{
    public function index(Request $request)
    {
        $token = session('api_token');
        $user  = session('user_data');
        $currentPage = $request->get('page');

        /**
         * -----------------------------------------
         * 1) Ambil seluruh antrian dari backend
         * -----------------------------------------
         */
        $all = Http::withToken($token)->get(env('API_URL') . '/admin/antrian', [
            'staff_id' => $user['id'],
        ])->json()['data'] ?? [];

        /**
         * -----------------------------------------
         * 2) Ambil nomor antrian terakhir "A-XXX"
         * -----------------------------------------
         */
        $last = collect($all)
            ->filter(fn($x) => !empty($x['no_antrian']))
            ->sortByDesc(function($x){
                return intval(str_replace('A-', '', $x['no_antrian']));
            })
            ->first();

        if ($last) {
            $lastNumber = intval(str_replace('A-', '', $last['no_antrian']));
            $next = $lastNumber + 1;
        } else {
            $next = 1;
        }

        // Format nomor antrian berikutnya
        $nextNomor = 'A-' . str_pad($next, 3, '0', STR_PAD_LEFT);

        /**
         * -----------------------------------------
         * 3) Ambil pasien sesuai klinik
         * -----------------------------------------
         */
        $pasienResponse = Http::withToken($token)
            ->get(env('API_URL') . '/resepsionis/pasien', [
                'staff_id' => $user['id'],
                'search'   => $request->search,
                'page'     => $currentPage,
            ]);

        $pasienData = $pasienResponse->json()['pasien'] ?? [];
        $idKlinik = $pasienResponse->json()['klinik'] ?? null;

        /**
         * -----------------------------------------
         * 4) Ambil dokter dan jadwal
         * -----------------------------------------
         */
        $dokterResponse = Http::withToken($token)
            ->get(env('API_URL') . '/resepsionis/dokter', [
                'staff_id' => $user['id']
            ]);

        $dokter = $dokterResponse->json()['dokter'] ?? [];

        $dokterJadwal = collect($dokter)->flatMap(function ($d) {
            return collect($d['jadwal'])->map(function ($j) use ($d) {
                return [
                    'id_dokter'   => $d['id'],
                    'id_jadwal'   => $j['id'],
                    'nama_dokter' => $d['nama_lengkap'],
                    'hari'        => $j['hari'],
                    'waktu'       => $j['jam_mulai'] . ' - ' . $j['jam_selesai'],
                ];
            });
        })->toArray();

        /**
         * -----------------------------------------
         * 5) Kirim ke view
         * -----------------------------------------
         */
        return view('staff.resepsionis.register-pasien', compact(
            'pasienData',
            'dokterJadwal',
            'idKlinik',
            'nextNomor'
        ));
    }

    public function storePasien(Request $request)
    {
        $token = session('api_token');
        $api = env('API_URL');

        // ---------------------------
        // 1. CEK DATA USER YANG DIKIRIM
        // ---------------------------
        $userPayload = [
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'pasien',
        ];

        $responseUser = Http::withToken($token)
            ->post("$api/resepsionis/users/tambah", $userPayload);

        if (!$responseUser->successful()) {
            return back()->with('error', $responseUser->json()['message'] ?? 'Gagal menambah user');
        }

        $userId = $responseUser->json()['user_id'];


        // --------------------------------
        // 2. CEK DATA PASIEN YANG DIKIRIM
        // --------------------------------
        $pasienPayload = [
            'user_id'        => $userId,
            'nama_lengkap'   => $request->nama_lengkap,
            'nik'            => $request->nik,
            'tgl_lahir'      => $request->tgl_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'alamat_domisili'=> $request->alamat_domisili,
            'no_hp'          => $request->no_hp,
            'golongan_darah' => $request->golongan_darah,
            'riwayat_alergi' => $request->riwayat_alergi,
        ];

        // Jika sudah benar, matikan dd di atas
        $responsePasien = Http::withToken($token)
            ->post("$api/resepsionis/pasien/tambah", $pasienPayload);

        if (!$responsePasien->successful()) {
            return back()->with('error', $responsePasien->json()['message'] ?? 'Gagal menambah pasien');
        }


        return back()->with('success', 'Pasien baru berhasil didaftarkan!');
    }



    public function storeKunjungan(Request $request)
    {
        $token = session('api_token');

    //     dd([
    //     'id_klinik' => $request->id_klinik,
    //     'id_pasien' => $request->id_pasien,
    //     'tgl_kunjungan' => $request->tgl_kunjungan,
    //     'no_antrian' => $request->no_antrian,
    //     'status' => $request->status,
    //     'id_jadwal' => $request->id_jadwal,
    //     'id_dokter' => $request->id_dokter,
    //     'keluhan' => $request->keluhan,
    // ]);
        $res = Http::withToken($token)->post(env('API_URL').'/resepsionis/kunjungan/tambah', [
            'id_klinik'    => $request->id_klinik,
            'id_pasien'    => $request->id_pasien,
            'tgl_kunjungan'=> $request->tgl_kunjungan,
            'no_antrian'   => $request->no_antrian,
            'status'       => $request->status,
            'id_jadwal'    => $request->id_jadwal,
            'id_dokter'    => $request->id_dokter,
            'keluhan'      => $request->keluhan,
        ]);
        
        return back()->with('success', 'Antrian berhasil ditambahkan!');
    }



}
