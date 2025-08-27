<?php

namespace App\Models;

use App\Traits\LogsHiveActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hive extends Model
{
    use HasFactory, LogsHiveActivity;

    protected static function booted()
    {
        static::creating(function ($hive) {
            if (empty($hive->slug)) {
                $uuid = (string) Str::uuid();
                $hive->slug = 'hive_' . $uuid;
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

    public function harvests()
    {
        return $this->hasMany(Harvest::class);
    }

    public function latestHarvest()
    {
        return $this->hasOne(Harvest::class)->latestOfMany();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function notes()
    {
        return $this->hasMany(HiveNote::class)->latest();
    }

    public function activities()
    {
        return $this->hasMany(HiveActivity::class)->latest();
    }

    public function hiveSupers()
    {
        return $this->hasMany(HiveSuper::class);
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'hive_state')->withPivot('cause')->withTimestamps();
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


    public static function getTypeOptions(): array
    {
        return ['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow'];
    }

    public function updateRating(Inspection $inspection)
    {
        $rating = 0;

        // Population: 25%
        $rating += ($inspection->population / 100) * 25;

        // Honey Stores: 20%
        $rating += ($inspection->honey_stores / 100) * 20;

        // Pollen Stores: 20%
        $rating += ($inspection->pollen_stores / 100) * 20;

        // Brood Pattern: 25%
        $rating += ($inspection->brood_pattern / 100) * 25;

        // Behavior (inverse relationship, less aggressive is better): 10%
        $rating += ((100 - $inspection->behavior) / 100) * 10;

        // Queen Status: 10%
        if (in_array($inspection->queen_status, ['Presente', 'Reina Fecundada'])) {
            $rating += 10;
        }

        // Pests and Diseases: 10%
        if ($inspection->pests_diseases === 'Sin plagas') {
            $rating += 10;
        }

        // The weights above sum to 120, so we need to normalize to 100.
        // The maximum possible score is 25+20+20+25+10+10+10 = 120.
        // Let's adjust the weights to sum to 100.
        // Population: 20, Honey: 15, Pollen: 15, Brood: 20, Behavior: 10, Queen: 10, Pests: 10 = 100

        $rating = 0;
        $rating += ($inspection->population / 100) * 20;
        $rating += ($inspection->honey_stores / 100) * 15;
        $rating += ($inspection->pollen_stores / 100) * 15;
        $rating += ($inspection->brood_pattern / 100) * 20;
        $rating += ((100 - $inspection->behavior) / 100) * 10;
        if (in_array($inspection->queen_status, ['Presente', 'Reina Fecundada'])) {
            $rating += 10;
        }
        if ($inspection->pests_diseases === 'Sin plagas') {
            $rating += 10;
        }


        $this->rating = min(100, max(0, round($rating)));
        $this->save();
    }
}
