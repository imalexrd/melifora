<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hive extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($hive) {
            if (empty($hive->slug)) {
                $uuid = (string) Str::uuid();
                $hive->slug = $uuid;
                if (empty($hive->name)) {
                    $hive->name = $uuid;
                }
            }
        });
    }

    protected $fillable = [
        'apiary_id',
        'name',
        'slug',
        'qr_code',
        'rating',
        'type',
        'birth_date',
        'location',
        'location_gps',
        'status',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function apiary()
    {
        return $this->belongsTo(Apiary::class);
    }

    public function queen()
    {
        return $this->hasOne(Queen::class);
    }

    public function queenHistories()
    {
        return $this->hasMany(QueenHistory::class);
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getStatusOptions(): array
    {
        return [
            'Desconocido', 'Activa', 'Invernando', 'Enjambrazon', 'Despoblada', 'Huerfana',
            'Zanganera', 'En formacion', 'Revision', 'Mantenimiento', 'Alimentacion Artificial',
            'Crianza de reinas', 'Pillaje', 'Pillera', 'Union', 'Sin uso'
        ];
    }

    public static function getTypeOptions(): array
    {
        return ['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow'];
    }
}
