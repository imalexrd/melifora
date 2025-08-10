<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'location_gps',
        'status',
    ];

    public static function getStatusOptions()
    {
        return [
            'Activo',
            'Inactivo',
            'Mantenimiento',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hives()
    {
        return $this->hasMany(Hive::class);
    }
}
