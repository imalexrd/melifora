<?php

namespace App\Traits;

use App\Models\Hive;
use App\Models\HiveActivity;

trait LogsHiveActivity
{
    /**
     * Log an activity for a hive.
     *
     * @param \App\Models\Hive $hive
     * @param string $description
     * @return void
     */
    protected function logActivity(Hive $hive, string $description)
    {
        HiveActivity::create([
            'hive_id' => $hive->id,
            'user_id' => auth()->id(),
            'description' => $description,
        ]);
    }
}
