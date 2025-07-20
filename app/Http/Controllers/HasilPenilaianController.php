<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilPenilaianController extends Controller
{
    public function index()
    {
        $query = Penilaian::select('nama_target', 'nama_periode')
            ->selectRaw('COUNT(DISTINCT nama_siswa) as jumlah_siswa')
            ->selectRaw('AVG(skor) as rata_rata')
            ->groupBy('nama_target', 'nama_periode')
            ->orderBy('nama_periode', 'desc')
            ->orderBy('nama_target');

        if (Auth::user()->role == 'guru' || Auth::user()->role == 'karyawan') {
            $name = Auth::user()->role == 'guru' ? Auth::user()->guru->nama : Auth::user()->karyawan->nama;
            $query->where('nama_target', $name);
        }

        $grouped = $query->get();

        return view('admin.hasil-penilaian.index', compact('grouped'));
    }

    public function detail(Request $request)
    {
        $nama_target = urldecode($request->nama_target);
        $nama_periode = urldecode($request->nama_periode);

        if (in_array(Auth::user()->role, ['guru', 'karyawan'])) {
            $nama_user = Auth::user()->role === 'guru'
                ? Auth::user()->guru->nama
                : Auth::user()->karyawan->nama;

            if ($nama_target !== $nama_user) {
                abort(403, 'Akses tidak diizinkan.');
            }
        }

        $grouped = Penilaian::query()
            ->select('nama_instrumen')
            ->selectRaw('AVG(skor) as rata_rata')
            ->selectRaw('COUNT(DISTINCT nama_siswa) as jumlah_penilai')
            ->where('nama_target', $nama_target)
            ->where('nama_periode', $nama_periode)
            ->groupBy('nama_instrumen')
            ->orderBy('nama_instrumen')
            ->get();

        return view('admin.hasil-penilaian.detail', compact('grouped', 'nama_target', 'nama_periode'));
    }
}
