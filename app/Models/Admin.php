<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id', 'nama'];
    protected $table = 'admin';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
