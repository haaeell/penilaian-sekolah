<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Guru;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruKaryawanController extends Controller
{
    public function hasilPenilaian()
    {
        $user = Auth::user();
        $penilaian = Penilaian::with(['instrumen', 'periode'])
            ->where('target_id', $user->id)
            ->get();

        return view('guru_karyawan.hasil', compact('penilaian'));
    }

    public function downloadHasil()
    {
        $user = Auth::user();
        $penilaian = Penilaian::with(['instrumen', 'periode'])
            ->where('target_id', $user->id)
            ->get();

        $pdf = Pdf::loadView('guru_karyawan.pdf', compact('penilaian'));
        return $pdf->download('hasil_penilaian.pdf');
    }
}
