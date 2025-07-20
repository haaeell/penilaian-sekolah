<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instrumen;
use App\Models\Karyawan;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{

    public function penilaian()
    {
        $periode = Periode::where('is_active', true)->first();
        if (!$periode) {
            return redirect()->back()->with('error', 'Tidak ada periode penilaian aktif');
        }

        $siswa = Siswa::where('user_id', Auth::id())->first();
        $guru = $siswa->kelas->guru;
        $karyawan = Karyawan::where('jurusan_id', $siswa->jurusan_id)->get();
        $instrumenGuru = Instrumen::where('target', 'guru')->get();
        $instrumenKaryawan = Instrumen::where('target', 'karyawan')
            ->where('jurusan_id', $siswa->jurusan_id)
            ->get();

        return view('siswa.penilaian', compact('guru', 'karyawan', 'instrumenGuru', 'instrumenKaryawan', 'periode'));
    }

    public function submitPenilaian(Request $request)
    {
        $periode = Periode::where('is_active', true)->first();
        if (!$periode) {
            return redirect()->back()->with('error', 'Tidak ada periode penilaian aktif');
        }

        $siswa = Siswa::where('user_id', Auth::id())->first();
        foreach ($request->skor as $instrumenId => $skor) {
            Penilaian::create([
                'siswa_id' => $siswa->id,
                'target_id' => $request->target_id,
                'instrumen_id' => $instrumenId,
                'periode_id' => $periode->id,
                'skor' => $skor
            ]);
        }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan');
    }
}
