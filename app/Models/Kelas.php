<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas', 'jurusan_id'];
    protected $table = 'kelas';

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_kelas', 'kelas_id', 'guru_id');
    }
}
