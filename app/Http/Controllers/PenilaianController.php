<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Instrumen;
use App\Models\Karyawan;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->with(['jurusan', 'kelas'])->first();
        $periode_aktif = Periode::where('is_active', 1)->first();

        if (!$periode_aktif) {
            return view('penilaian_siswa', [
                'periode_aktif' => null,
                'guru' => [],
                'karyawan' => [],
                'instrumen_guru' => [],
                'instrumen_karyawan' => [],
                'penilaian_data' => [],
                'siswa' => $siswa
            ]);
        }

        $guru = Guru::with('user')->whereHas('kelas', function ($query) use ($siswa) {
            $query->where('kelas.id', $siswa->kelas_id);
        })->get();

        $instrumen_guru = Instrumen::where('target', 'guru')->get();
        $karyawan = Karyawan::where('jurusan_id', $siswa->jurusan_id)->get();
        $instrumen_karyawan = Instrumen::where('target', 'karyawan')->where('jurusan_id', $siswa->jurusan_id)->get();

        $penilaian_data = Penilaian::where('siswa_id', $siswa->id)->where('periode_id', $periode_aktif->id)->get();

        return view('siswa.penilaian.index', compact('periode_aktif', 'guru', 'karyawan', 'instrumen_guru', 'instrumen_karyawan', 'penilaian_data', 'siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'periode_id' => 'required|exists:periode,id',
            'target_ids' => 'required|array',
            'target_ids.guru.*' => 'sometimes|exists:guru,id',
            'target_ids.karyawan.*' => 'sometimes|exists:karyawan,id',
            'skor' => 'required|array',
            'skor.guru.*.*' => 'sometimes|integer|min:1|max:4',
            'skor.karyawan.*.*' => 'sometimes|integer|min:1|max:4',
        ]);

        $siswa = Siswa::findOrFail($validated['siswa_id']);
        $periode = Periode::findOrFail($validated['periode_id']);

        if (isset($validated['target_ids']['guru']) && isset($validated['skor']['guru'])) {
            foreach ($validated['target_ids']['guru'] as $guruId) {
                $guru = Guru::findOrFail($guruId);
                if (isset($validated['skor']['guru'][$guruId])) {
                    foreach ($validated['skor']['guru'][$guruId] as $instrumenId => $skor) {
                        $instrumen = Instrumen::findOrFail($instrumenId);
                        Penilaian::updateOrCreate(
                            [
                                'siswa_id' => $siswa->id,
                                'periode_id' => $periode->id,
                                'target_id' => $guru->id,
                                'instrumen_id' => $instrumen->id,
                            ],
                            [
                                'nama_siswa' => $siswa->nama,
                                'nama_target' => $guru->nama,
                                'nama_instrumen' => $instrumen->pertanyaan,
                                'nama_periode' => $periode->nama_periode,
                                'skor' => $skor,
                            ]
                        );
                    }
                }
            }
        }

        if (isset($validated['target_ids']['karyawan']) && isset($validated['skor']['karyawan'])) {
            foreach ($validated['target_ids']['karyawan'] as $karyawanId) {
                $karyawan = Karyawan::findOrFail($karyawanId);
                if (isset($validated['skor']['karyawan'][$karyawanId])) {
                    foreach ($validated['skor']['karyawan'][$karyawanId] as $instrumenId => $skor) {
                        $instrumen = Instrumen::findOrFail($instrumenId);
                        Penilaian::updateOrCreate(
                            [
                                'siswa_id' => $siswa->id,
                                'periode_id' => $periode->id,
                                'target_id' => $karyawan->id,
                                'instrumen_id' => $instrumen->id,
                            ],
                            [
                                'nama_siswa' => $siswa->nama,
                                'nama_target' => $karyawan->nama,
                                'nama_instrumen' => $instrumen->pertanyaan,
                                'nama_periode' => $periode->nama_periode,
                                'skor' => $skor,
                            ]
                        );
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
    }
}
