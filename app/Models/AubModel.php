<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AubModel extends Model
{
    use HasFactory;

    protected $table = 'aub';
    protected $primaryKey = 'idaub';
    protected $fillable = [
        'kodeaub',
        'namaaub',
    ];

    public function plant(): HasMany
    {
        return $this->hasMany(PlantModel::class, 'idplant', 'idplant');
    }
}