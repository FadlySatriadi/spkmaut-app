<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlternatifModel extends Model
{
    use HasFactory;

    protected $table = 'alternatif';
    protected $primaryKey = 'idalternatif';
    protected $fillable = [
        'idplant',
        'kodealternatif',
    ];

    // Relasi ke PlantModel (many-to-one)
    public function plant(): BelongsTo
    {
        return $this->belongsTo(PlantModel::class, 'idplant', 'idplant');
    }
}