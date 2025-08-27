<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apiary;
use App\Models\Hive;
use Illuminate\Support\Str;

class BackfillSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill slugs for existing apiaries and hives';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Backfilling slugs for apiaries...');
        $apiaries = Apiary::whereNull('slug')->get();
        foreach ($apiaries as $apiary) {
            $apiary->slug = 'apiary_' . ((string) Str::uuid());
            $apiary->save();
        }
        $this->info('Apiary slugs backfilled.');

        $this->info('Backfilling slugs for hives...');
        $hives = Hive::whereNull('slug')->orWhere('slug', 'not like', 'hive_%')->get();
        foreach ($hives as $hive) {
            $hive->slug = 'hive_' . ((string) Str::uuid());
            $hive->save();
        }
        $this->info('Hive slugs backfilled.');
    }
}
