<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiaryNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'apiary_id',
        'content',
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
