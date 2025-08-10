<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiaryActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'apiary_id',
        'user_id',
        'description',
    ];

    public function apiary()
    {
        return $this->belongsTo(Apiary::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
