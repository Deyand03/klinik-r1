<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RujukanDigitalController extends Controller
{
    public function rujukanDigital()
    {
        return view('admin.rujukan_digital.index');
    }

    public function storeRujukanDigital(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'referral_reason' => 'required|string',
            'referral_date' => 'required|date',
        ]);

        // Simpan data rujukan digital ke database (contoh menggunakan model RujukanDigital)
        // RujukanDigital::create($validatedData);

        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->route('admin.rujukan-digital')->with('success', 'Rujukan digital berhasil disimpan.');
    }
}
