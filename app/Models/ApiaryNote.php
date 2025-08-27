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
        'type',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
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
