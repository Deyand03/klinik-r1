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

        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

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
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        return view('admin.kelola_pegawai.create', compact('clinics'));
    }

    // --- UPDATE PENTING DI SINI (STORE) ---
    public function store(Request $request)
    {
        $token = session('api_token');
        $http = Http::withToken($token);

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $http->attach(
                'foto_profil',
                file_get_contents($file),
                $file->getClientOriginalName()
            );
        }

        $response = $http->post(env('API_URL') . '/admin/staff', $request->except('foto_profil'));

        if ($response->successful()) {
            return redirect()->route('admin.staff.index')->with('success', 'Pegawai berhasil ditambahkan!');
        }

        // TANGKAP ERROR VALIDASI (422)
        if ($response->status() == 422) {
            $errors = $response->json()['errors'] ?? [];
            // withErrors() ini kuncinya biar @error di blade jalan
            return back()->withErrors($errors)->withInput()->with('error', 'Validasi gagal, silakan periksa inputan Anda.');
        }

        return back()->with('error', 'Gagal: ' . ($response->json()['message'] ?? 'Error Server'))->withInput();
    }

    public function edit($id)
    {
        $token = session('api_token');
        $responseDetail = Http::withToken($token)->get(env('API_URL') . '/admin/staff/' . $id);

        if (!$responseDetail->successful()) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $staff = $responseDetail->json()['data'];

        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        return view('admin.kelola_pegawai.edit', compact('staff', 'clinics'));
    }

    // --- UPDATE PENTING DI SINI (UPDATE) ---
    public function update(Request $request, $id)
    {
        $token = session('api_token');
        $http = Http::withToken($token);

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $http->attach(
                'foto_profil',
                file_get_contents($file),
                $file->getClientOriginalName()
            );
        }

        $data = $request->except('foto_profil');
        $data['_method'] = 'PUT';

        $response = $http->post(env('API_URL') . '/admin/staff/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.staff.index')->with('success', 'Data pegawai diperbarui!');
        }

        // Validasi 422 juga ditangani disini
        if ($response->status() == 422) {
            $errors = $response->json()['errors'] ?? [];
            return back()->withErrors($errors)->withInput()->with('error', 'Validasi gagal.');
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
