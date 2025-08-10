<?php

namespace App\Traits;

use App\Models\Apiary;
use App\Models\ApiaryActivity;

trait LogsApiaryActivity
{
    /**
     * Log an activity for an apiary.
     *
     * @param \App\Models\Apiary $apiary
     * @param string $description
     * @return void
     */
    protected function logActivity(Apiary $apiary, string $description)
    {
        ApiaryActivity::create([
            'apiary_id' => $apiary->id,
            'user_id' => auth()->id(),
            'description' => $description,
        ]);
    }
}
