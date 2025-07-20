<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = ['nama_jurusan'];
    protected $table = 'jurusan';

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function instrumen()
    {
        return $this->hasMany(Instrumen::class);
    }
}
