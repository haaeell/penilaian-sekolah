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

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $kelas = Kelas::all();

        return view('admin.users.index', compact('users', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,guru,karyawan,siswa',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'role' => 'siswa',
            'password' => Hash::make($request->password),
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nama' => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->siswa()->update([
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->siswa()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }
}
