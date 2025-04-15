<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'idkriteria';
    protected $fillable = [
        'namakriteria',
        'kodekriteria',
        'bobotkriteria',
        'jeniskriteria'
    ];
}