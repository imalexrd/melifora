<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'category',
    ];

    public function hives()
    {
        return $this->belongsToMany(Hive::class)->withTimestamps();
    }
}
