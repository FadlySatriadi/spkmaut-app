<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryModel extends Model
{
    protected $table = 'riwayat';
    protected $fillable = ['iduser', 'calculation_date', 'ranking_data', 'calculation_details'];
    protected $casts = [
        'ranking_data' => 'array',
        'calculation_details' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
