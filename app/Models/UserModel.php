<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user'; // Sesuaikan dengan tabel Anda
    protected $primaryKey = 'iduser'; // Sesuaikan
    protected $fillable = [
        'username', // Pastikan sesuai dengan field di database
        'nama',
        'password',
        'idrole'
    ];

    protected $hidden = [
        'password',
    ];
}