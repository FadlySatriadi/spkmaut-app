<?php
// app/Models/RecommendationHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationHistory extends Model
{
    protected $fillable = [
        'iduser', 
        'calculation_data',
        'top_plant_name',
        'top_plant_score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}