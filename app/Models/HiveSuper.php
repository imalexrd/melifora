<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HiveSuper extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($hiveSuper) {
            if (empty($hiveSuper->tracking_code)) {
                $hiveSuper->tracking_code = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'hive_id',
        'tracking_code',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}
