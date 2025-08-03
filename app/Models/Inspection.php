<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'inspection_date',
        'queen_status',
        'population',
        'honey_stores',
        'pollen_stores',
        'brood_pattern',
        'behavior',
        'pests_diseases',
        'treatments',
        'notes',
    ];

    protected $casts = [
        'inspection_date' => 'date',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}
