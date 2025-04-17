<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perhitungan',
        'data_plants',
        'data_kriteria',
        'hasil_perhitungan',
        'iduser'
    ];

    protected $casts = [
        'data_plants' => 'array',
        'data_kriteria' => 'array',
        'hasil_perhitungan' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}