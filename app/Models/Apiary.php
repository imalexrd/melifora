<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Apiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'location',
        'location_gps',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($apiary) {
            if (empty($apiary->slug)) {
                $uuid = (string) Str::uuid();
                $apiary->slug = 'apiary_' . $uuid;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getStatusOptions()
    {
        return [
            'Activo',
            'Inactivo',
            'Mantenimiento',
            'Cuarentena',
            'Dividido',
            'Fusionado',
        ];
    }

    public static function getStatusColorMap()
    {
        return [
            'Activo' => 'bg-green-500',
            'Inactivo' => 'bg-gray-500',
            'Mantenimiento' => 'bg-blue-500',
            'Cuarentena' => 'bg-yellow-500',
            'Dividido' => 'bg-purple-500',
            'Fusionado' => 'bg-pink-500',
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

    public function notes()
    {
        return $this->hasMany(ApiaryNote::class)->latest();
    }

    public function activities()
    {
        return $this->hasMany(ApiaryActivity::class)->latest();
    }
}
