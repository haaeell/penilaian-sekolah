<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = Periode::all();
        return view('admin.periode.index', compact('periode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'is_active' => 'required|boolean'
        ]);

        Periode::create($request->only('nama_periode', 'waktu_mulai', 'waktu_selesai', 'is_active'));

        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function update(Request $request, Periode $periode)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after_or_equal:waktu_mulai',
            'is_active' => 'required|boolean'
        ]);

        $periode->update($request->only('nama_periode', 'waktu_mulai', 'waktu_selesai', 'is_active'));

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy(Periode $periode)
    {
        if ($periode->penilaian()->count() > 0) {
            return redirect()->route('periode.index')->with('error', 'Periode tidak dapat dihapus karena sudah memiliki penilaian.');
        }

        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus.');
    }
}
