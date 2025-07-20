<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumen extends Model
{
    protected $fillable = ['pertanyaan', 'target', 'jurusan_id'];
    protected $table = 'instrumen';

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
