<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; // Sesuaikan dengan tabel Anda
    protected $primaryKey = 'iduser'; // Sesuaikan

    protected $fillable = [
        'username',
        'nama',
        'role',
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'idrole');
    }
    
    public function getNameAttribute()
    {
        return $this->attributes['nama'];
    }
    
    protected $hidden = [
        'password',
    ];
}