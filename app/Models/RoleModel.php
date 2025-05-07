<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    public $timestamps = true;

    protected $fillable = [
        'koderole',
        'namarole'
    ];

    // Relasi ke User melalui tabel pivot admin/officer
    public function adminUsers()
    {
        return $this->belongsToMany(User::class, 'admin', 'idrole', 'iduser');
    }

    public function officerUsers()
    {
        return $this->belongsToMany(User::class, 'officer', 'idrole', 'iduser');
    }

    // Helper method untuk cek role
    public static function getAdminRole()
    {
        return self::where('namarole', 'admin')->first();
    }

    public static function getOfficerRole()
    {
        return self::where('namarole', 'officer')->first();
    }
}