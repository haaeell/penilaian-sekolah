<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class InstrumenController extends Controller
{
    public function index()
    {
        $instrumen = Instrumen::with('jurusan')->get();
        $jurusan = Jurusan::all();
        return view('admin.instrumen.index', compact('instrumen', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'target' => 'required|in:guru,karyawan',
            'jurusan_id' => 'nullable|exists:jurusan,id'
        ]);
        Instrumen::create($request->only('pertanyaan', 'target', 'jurusan_id'));
        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $instrumen = Instrumen::findOrFail($id);
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'target' => 'required|in:guru,karyawan',
            'jurusan_id' => 'nullable|exists:jurusan,id'
        ]);
        $instrumen->update($request->only('pertanyaan', 'target', 'jurusan_id'));
        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $instrumen = Instrumen::findOrFail($id);
        $instrumen->delete();
        return redirect()->route('instrumen.index')->with('success', 'Instrumen berhasil dihapus.');
    }
}
