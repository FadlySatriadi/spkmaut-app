<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RangkingModel extends Model
{
    use HasFactory;

    protected $table = 'rangking';
    protected $primaryKey = 'idpenilaian';
    protected $fillable = [
        'idpenilaian',
        'peringkat'
    ];

    public function penilaian()
    {
        return $this->belongsTo(PenilaianModel::class, 'idpenilaian', 'idpenilaian');
    }
}