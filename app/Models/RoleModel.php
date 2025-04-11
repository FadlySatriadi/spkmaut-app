<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'idrole';
    protected $fillable = [
        'nama_role',
        'deskripsi',
    ];

    public function plant(): HasMany
    {
        return $this->hasMany(PlantModel::class, 'idplant', 'idplant');
    }
}