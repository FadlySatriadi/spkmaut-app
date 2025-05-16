<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'iduser';

    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'iduser', 'iduser');
    }

    public function officer()
    {
        return $this->hasOne(Officer::class, 'iduser', 'iduser');
    }
}
