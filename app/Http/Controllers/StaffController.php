<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $token = session('api_token');

        // Ambil List Klinik untuk Filter
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        // Ambil Data Staff
        $responseStaff = Http::withToken($token)->get(env('API_URL') . '/admin/staff', [
            'clinic_id' => $request->clinic_id,
            'search' => $request->search
        ]);

        $staffs = $responseStaff->successful() ? $responseStaff->json()['data'] : [];

        return view('admin.kelola_pegawai.index', compact('staffs', 'clinics'));
    }

    public function create()
    {
        $token = session('api_token');
        // Ambil List Klinik buat dropdown tambah pegawai
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        return view('admin.kelola_pegawai.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        // Siapkan Request HTTP
        $http = Http::withToken($token);

        // Cek apakah ada file foto yang diupload
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            // Attach file ke request (seperti multipart/form-data)
            $http->attach(
                'foto_profil',
                file_get_contents($file),
                $file->getClientOriginalName()
            );
        }

        // Kirim sisa data (text inputs)
        $response = $http->post(env('API_URL') . '/admin/staff', $request->except('foto_profil'));

        if ($response->successful()) {
            return redirect()->route('admin.staff.index')->with('success', 'Pegawai berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal: ' . ($response->json()['message'] ?? 'Validasi Gagal'))->withInput();
    }

    public function edit($id)
    {
        $token = session('api_token');

        // Ambil Detail Staff
        $responseDetail = Http::withToken($token)->get(env('API_URL') . '/admin/staff/' . $id);

        if (!$responseDetail->successful()) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $staff = $responseDetail->json()['data'];

        // Ambil List Klinik
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        return view('admin.kelola_pegawai.edit', compact('staff', 'clinics'));
    }

    public function update(Request $request, $id)
    {
        $token = session('api_token');
        $http = Http::withToken($token);

        // Cek file update
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $http->attach(
                'foto_profil',
                file_get_contents($file),
                $file->getClientOriginalName()
            );
        }

        // Kalau update, API biasanya pakai PUT.
        // Tapi Laravel Client Multipart kadang error di PUT, lebih aman pakai POST dengan method spoofing
        // ATAU tetap PUT jika attach support (versi terbaru support). Kita coba standard PUT dulu.
        // Jika error, ganti jadi ->post(..., array_merge($request->all(), ['_method' => 'PUT']))

        // Tips: Untuk update file via API Laravel, paling aman pakai POST dengan _method = PUT
        $data = $request->except('foto_profil');
        $data['_method'] = 'PUT'; // Trik biar backend baca sebagai PUT

        $response = $http->post(env('API_URL') . '/admin/staff/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.staff.index')->with('success', 'Data pegawai diperbarui!');
        }

        return back()->with('error', 'Gagal: ' . ($response->json()['message'] ?? 'Error Server'))->withInput();
    }

    public function destroy($id)
    {
        $token = session('api_token');
        $response = Http::withToken($token)->delete(env('API_URL') . '/admin/staff/' . $id);

        if ($response->successful()) {
            return back()->with('success', 'Pegawai berhasil dihapus');
        }
        return back()->with('error', 'Gagal menghapus pegawai');
    }
}
