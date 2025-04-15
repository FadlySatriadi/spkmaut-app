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
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}