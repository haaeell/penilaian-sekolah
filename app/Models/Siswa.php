<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['user_id', 'nama', 'kelas_id', 'jurusan_id'];
    protected $table = 'siswa';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
