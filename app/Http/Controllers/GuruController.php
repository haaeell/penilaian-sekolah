<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Karyawan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'guru')->get();
        $kelas = Kelas::all();

        return view('admin.users.guru.index', compact('users', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'role' => 'guru',
            'password' => Hash::make($request->password),
        ]);

        Guru::create(['user_id' => $user->id, 'nama' => $request->nama]);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nama' => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
        ]);

        $user->guru()->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->guru()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Guru berhasil dihapus.');
    }
}
