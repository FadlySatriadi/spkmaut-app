<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AubModel extends Model
{
    use HasFactory;

    protected $table = 'aub';
    protected $primaryKey = 'idaub';
    protected $fillable = [
        'kodeaub',
        'aub',
    ];
}