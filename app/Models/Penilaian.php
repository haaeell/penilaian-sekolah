<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['nama_siswa', 'nama_target', 'nama_instrumen', 'nama_periode', 'siswa_id', 'target_id', 'instrumen_id', 'periode_id', 'skor'];
    protected $table = 'penilaian';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public function instrumen()
    {
        return $this->belongsTo(Instrumen::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
