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
        $response = Http::withToken($token)->post(env('API_URL') . '/admin/staff', $request->all());

        if ($response->successful()) {
            return redirect()->route('admin.staff.index')->with('success', 'Pegawai baru berhasil ditambahkan!');
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
        $response = Http::withToken($token)->put(env('API_URL') . '/admin/staff/' . $id, $request->all());

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
