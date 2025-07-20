<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Karyawan;
use App\Models\Siswa;
use App\Models\Instrumen;
use App\Models\Periode;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.users.admin.index', compact('users'));
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
        ]);

        Admin::create(['user_id' => $user->id, 'nama' => $request->nama]);

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
        ]);

        $user->admin()->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->admin()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
