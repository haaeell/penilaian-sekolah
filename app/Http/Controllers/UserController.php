<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Karyawan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');

        $users = User::when($role, fn($q) => $q->where('role', $role))->get();
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();

        return view('admin.users.index', compact('users', 'jurusan', 'kelas'));
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
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        match ($request->role) {
            'admin' => Admin::create(['user_id' => $user->id, 'nama' => $request->nama]),
            'guru' => Guru::create(['user_id' => $user->id, 'nama' => $request->nama]),
            'karyawan' => Karyawan::create(['user_id' => $user->id, 'nama' => $request->nama]),
            'siswa' => Siswa::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'kelas_id' => $request->kelas_id,
            ]),
        };

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nama' => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
            'jurusan_id' => $request->jurusan_id,
            'kelas_id' => $request->kelas_id,
        ]);

        match ($user->role) {
            'admin' => $user->admin()->update(['nama' => $request->nama]),
            'guru' => $user->guru()->update(['nama' => $request->nama]),
            'karyawan' => $user->karyawan()->update(['nama' => $request->nama]),
            'siswa' => $user->siswa()->update([
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'kelas_id' => $request->kelas_id,
            ]),
        };

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        match ($user->role) {
            'admin' => $user->admin()->delete(),
            'guru' => $user->guru()->delete(),
            'karyawan' => $user->karyawan()->delete(),
            'siswa' => $user->siswa()->delete(),
        };

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
