<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'karyawan')->get();
        $jurusan = Jurusan::all();

        return view('admin.users.karyawan.index', compact('users', 'jurusan'));
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
            'role' => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        Karyawan::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
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
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        $user->karyawan()->update([
            'nama' => $request->name,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->karyawan()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
    }
}
