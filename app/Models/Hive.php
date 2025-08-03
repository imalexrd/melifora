<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hive extends Model
{
    use HasFactory;

    protected $fillable = [
        'apiary_id',
        'name',
        'slug',
        'qr_code',
        'rating',
        'type',
        'birth_date',
        'location',
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
}
