<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RekamMedisController extends Controller
{
    public function index()
    {
        $token = session('api_token');
        $user = session('user_data');
        $user['id'];
            
        $res = Http::withToken($token)->get(env('API_URL') . '/admin/rekam-medis', [
            'staff_id' => $user['id'],
        ]);

        if ($res->status() === 401) {
            return redirect('login')->with(
                'error',
                'Sesi habis, silahkan login kembali'
            );
        }
        $data = $res->json(); 

        $klinik = $data['klinik_id'] ?? [];
        $rekamMedis = $data['rekam_medis'] ?? [];
        $kunjungan = $data['kunjungan'] ?? [];
        
        $rawObat = $data['obat'] ?? [];

        // Paksa array
        if (!is_array($rawObat)) {
            $rawObat = [];
        }

        $obat = [];

        foreach ($rawObat as $item) {
            if (is_array($item)) {
              
                $obat[] = $item;
            } else {
            
                $obat[] = [
                    "id" => $item,
                    "nama_obat" => "Obat ID $item (data tidak lengkap)"
                ];
            }
        }
        // dd($obat);
        return view('admin.rekam_medis.index', compact('rekamMedis', 'klinik', 'kunjungan', 'obat'));
    }
    // public function store(Request $request)
    // {
    //     $token = session('api_token');

    //     $res = Http::withHeaders([
    //         'Accept' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->post(env('API_URL') . '/rekam-medis/tambah', [
    //         'id_kunjungan'   => $request->no_kunjungan,
    //         'anamnesa'       => $request->anamnesa,
    //         'tensi_darah'    => $request->tensi_darah,
    //         'berat_badan'    => $request->berat_badan,
    //         'suhu_tubuh'     => $request->suhu_tubuh,
    //         'diagnosa'       => $request->diagnosa,
    //         'tindakan'       => $request->tindakan,
    //         'catatan_dokter' => $request->catatan_dokter,

    //         // MATA
    //         'visus_od'        => $request->visus_od,
    //         'visus_os'        => $request->visus_os,
    //         'sphere_od'       => $request->sphere_od,
    //         'sphere_os'       => $request->sphere_os,
    //         'cylinder_od'     => $request->cylinder_od,
    //         'cylinder_os'     => $request->cylinder_os,
    //         'axis_od'         => $request->axis_od,
    //         'axis_os'         => $request->axis_os,
    //         'pd'              => $request->pd,

    //         // GIZI
    //         'tinggi_badan'   => $request->tinggi_badan,
    //         'imt'            => $request->imt,
    //         'lingkar_perut'  => $request->lingkar_perut,
    //         'status_gizi'    => $request->status_gizi,
    //     ]);

    //     if ($res->failed()) {
    //         return back()->with('error', 'Gagal menambahkan rekam medis');
    //     }

    //     return redirect('/admin/rekam-medis')->with('success', 'Rekam medis berhasil ditambahkan!');
    // }


}
