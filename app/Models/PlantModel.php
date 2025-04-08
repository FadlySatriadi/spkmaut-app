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
        'lokasi',
        'status',
    ];

    public function aub()
    {
        return $this->belongsTo(AubModel::class, 'idaub', 'idaub');
    }
}