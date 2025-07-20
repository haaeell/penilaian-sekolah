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
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'admin')->get();
        return view('admin.users.admin.index', compact('users'));
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
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        Admin::create(['user_id' => $user->id, 'nama' => $request->name]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
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
        ]);

        $user->admin()->update(['nama' => $request->name]);

        return redirect()->back()->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->admin()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }
}
