<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queen extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'breed',
        'introduction_date',
        'age',
    ];

    protected $casts = [
        'introduction_date' => 'date',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}
