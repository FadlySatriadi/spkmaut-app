<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenilaianModel extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'idpenilaian';

    protected $fillable = [
        'iduser',
        'idalternatif',
        'idkriteria',
        'minmax',
        'matrixnormalisasi',
        'hasil',
        'created_at',
        'updated_at'
    ];


    // public function user()
    // {
    //     return $this->belongsTo(UserModel::class, 'iduser', 'iduser');
    // }

    // Relasi dengan alternatif
    public function alternatif()
    {
        return $this->belongsTo(AlternatifModel::class, 'idalternatif');
    }

    // Relasi dengan kriteria
    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'idkriteria');
    }

    // Scope untuk pencarian
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('alternatif', function ($query) use ($search) {
                $query->where('kodealternatif', 'like', '%' . $search . '%');
            });
        });
    }
}
