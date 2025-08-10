<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiveActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'user_id',
        'description',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
