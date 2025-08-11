<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'harvest_date',
        'quantity_kg',
        'quantity_liters',
        'density',
        'color_tone',
        'origin',
        'notes',
    ];

    protected $casts = [
        'harvest_date' => 'date',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}
