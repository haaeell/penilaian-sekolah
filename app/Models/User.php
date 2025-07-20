<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'password', 'role'];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'target_id');
    }
}
