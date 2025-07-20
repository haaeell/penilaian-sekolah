<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255',
        ]);

        $user = User::create([
            'email' => $request->email,
            'role' => 'guru',
            'password' => Hash::make($request->password),
        ]);

        $guru = Guru::create([
            'user_id' => $user->id,
            'nama' => $request->name
        ]);

        if ($request->has('kelas_id')) {
            $guru->kelas()->sync($request->kelas_id);
        }

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $guru = $user->guru;

        if (!$guru) {
            return redirect()->route('guru.index')->with('error', 'Data guru tidak ditemukan.');
        }

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'kelas_id' => 'nullable|array',
            'kelas_id.*' => 'exists:kelas,id'
        ]);

        $user->update([
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $guru->update([
            'nama' => $request->name
        ]);

        if ($request->has('kelas_id')) {
            $guru->kelas()->sync($request->kelas_id);
        } else {
            $guru->kelas()->detach();
        }

        return redirect()->back()->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->guru()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Guru berhasil dihapus.');
    }
}
