<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = ['nama_periode', 'waktu_mulai', 'waktu_selesai', 'is_active'];
    protected $table = 'periode';

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
