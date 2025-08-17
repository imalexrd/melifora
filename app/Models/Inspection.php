<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'hive_id',
        'inspection_date',
        'queen_status',
        'population',
        'honey_stores',
        'pollen_stores',
        'brood_pattern',
        'behavior',
        'pests_diseases',
        'treatments',
        'notes',
    ];

    protected $casts = [
        'inspection_date' => 'date',
    ];

    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }

    public static function getQueenStatusOptions(): array
    {
        return ['Desconocido', 'Presente', 'Ausente', 'Reina Virgen', 'Reina Fecundada', 'Celulas Reales'];
    }

    public static function getPestsAndDiseasesOptions(): array
    {
        return ['Sin plagas', 'Varroa', 'Loque Americana', 'Loque Europea', 'Polilla de la cera', 'Escarabajo de la colmena', 'Nariz blanca', 'Piojo de la abeja', 'Acaro traqueal'];
    }

    public static function getTreatmentsOptions(): array
    {
        return ['Sin tratamiento', 'Ácido oxálico', 'Timol', 'Ácido fórmico', 'Amitraz', 'Flumetrina'];
    }

    protected static function booted()
    {
        static::saved(function ($inspection) {
            $inspection->updateHiveState();
            $inspection->hive->updateRating($inspection);
        });
    }

    public function updateHiveState()
    {
        $hive = $this->hive;
        $statesToSync = [];
        $cause = "Inspección del " . $this->inspection_date->format('d/m/Y');

        // Get manually added states first.
        $manualStates = $hive->states()->wherePivot('cause', 'not like', 'Inspección del%')->get();
        foreach ($manualStates as $state) {
            $statesToSync[$state->id] = ['cause' => $state->pivot->cause];
        }

        // Now, calculate the new states from this inspection.
        // Queen status
        if ($this->queen_status === 'Ausente') {
            $state = State::firstOrCreate(['name' => 'Huerfana'], ['description' => 'La colmena no tiene reina.', 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Population
        if ($this->population < 40) {
            $state = State::firstOrCreate(['name' => 'Población baja'], ['description' => 'La población de abejas es baja.', 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Honey stores
        if ($this->honey_stores < 20) {
            $state = State::firstOrCreate(['name' => 'Reservas de miel bajas'], ['description' => 'Las reservas de miel son bajas.', 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Pollen stores
        if ($this->pollen_stores < 20) {
            $state = State::firstOrCreate(['name' => 'Reservas de polen bajas'], ['description' => 'Las reservas de polen son bajas.', 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Behavior
        if ($this->behavior > 80) {
            $state = State::firstOrCreate(['name' => 'Agresiva'], ['description' => 'La colmena es muy agresiva.', 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Pests and diseases
        if ($this->pests_diseases !== 'Sin plagas') {
            $state = State::firstOrCreate(['name' => $this->pests_diseases], ['description' => 'Presencia de ' . $this->pests_diseases, 'type' => 'bad']);
            $statesToSync[$state->id] = ['cause' => $cause];

            if ($this->treatments === 'Sin tratamiento') {
                $state = State::firstOrCreate(['name' => 'Enferma sin tratamiento'], ['description' => 'La colmena está enferma y no está recibiendo tratamiento.', 'type' => 'bad']);
                $statesToSync[$state->id] = ['cause' => $cause];
            } else {
                $state = State::firstOrCreate(['name' => 'Enferma con tratamiento'], ['description' => 'La colmena está enferma y está recibiendo tratamiento.', 'type' => 'neutral']);
                $statesToSync[$state->id] = ['cause' => $cause];
            }
        }

        $hive->states()->sync($statesToSync);
    }
}
