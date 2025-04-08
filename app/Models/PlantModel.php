<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantModel extends Model
{
    use HasFactory;

    protected $table = 'plant';
    protected $primaryKey = 'idplant';
    protected $fillable = [
        'idplant',
        'idaub',
        'namaplant',
        'kodeplant',
        'status',
    ];

    const STATUSES = [
        'aktif' => 'aktif',
        'nonaktif' => 'nonaktif',
    ];

    public static function getStatusOptions()
    {
        return array_keys(self::STATUSES);
    }

    public function aub()
    {
        return $this->belongsTo(AubModel::class, 'idaub', 'idaub');
    }
    public function alternatifs(): HasMany
    {
        return $this->hasMany(AlternatifModel::class, 'idplant', 'idplant');
    }
}