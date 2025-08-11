<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueenHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'queen_id',
        'change_date',
        'reason',
        'notes',
        'queen_breed',
        'queen_introduction_date',
        'queen_age',
    ];

    protected $casts = [
        'change_date' => 'date',
        'queen_introduction_date' => 'date',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }

    public function queen()
    {
        return $this->belongsTo(Queen::class);
    }
}
