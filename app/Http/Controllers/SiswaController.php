<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Instrumen;
use App\Models\Jurusan;
use App\Models\Karyawan;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'siswa')->get();
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();

        return view('admin.users.siswa.index', compact('users', 'kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'role' => 'siswa',
            'password' => Hash::make($request->password),
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'nama' => $request->name,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id, 'id'),
            ],
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->siswa()->update([
            'nama' => $request->name,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->siswa()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function getKelasByJurusan($id)
    {
        $kelas = Kelas::where('jurusan_id', $id)->get();
        return response()->json($kelas);
    }
}
