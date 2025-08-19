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
        'anomalies',
        'social_states',
        'season_states',
        'admin_states',
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

    public static function getAnomaliesOptions(): array
    {
        return ['Sin anomalias', 'Enjambrazon', 'Zanganera'];
    }

    public static function getSocialStatesOptions(): array
    {
        return ['Normal', 'Pillaje', 'Pillera', 'Deriva'];
    }

    public static function getSeasonStatesOptions(): array
    {
        return ['Normal', 'Expansion', 'Produccion', 'Almacenamiento', 'Invernando'];
    }

    public static function getAdminStatesOptions(): array
    {
        return ['Sin accion', 'Revision', 'Mantenimiento', 'Alimentacion artificial', 'Union', 'Division', 'Crianza de reynas'];
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
            $state = State::firstOrCreate(['name' => $this->pests_diseases], ['description' => 'Presencia de ' . $this->pests_diseases, 'type' => 'bad', 'category' => 'Plagas y Enfermedades']);
            $statesToSync[$state->id] = ['cause' => $cause];

            if ($this->treatments === 'Sin tratamiento') {
                $state = State::firstOrCreate(['name' => 'Enferma sin tratamiento'], ['description' => 'La colmena está enferma y no está recibiendo tratamiento.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)']);
                $statesToSync[$state->id] = ['cause' => $cause];
            } else {
                $state = State::firstOrCreate(['name' => 'Enferma con tratamiento'], ['description' => 'La colmena está enferma y está recibiendo tratamiento.', 'type' => 'neutral', 'category' => 'Indicadores de Inspección (Negativo)']);
                $statesToSync[$state->id] = ['cause' => $cause];
            }
        }

        // Positive states
        if ($this->population > 80 && $this->honey_stores > 80 && $this->pollen_stores > 80 && $this->brood_pattern > 80 && $this->behavior < 20) {
            $state = State::firstOrCreate(['name' => 'Óptima'], ['description' => 'La colmena está en condiciones óptimas.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        } elseif ($this->population > 60 && $this->honey_stores > 60 && $this->pollen_stores > 60 && $this->brood_pattern > 60 && $this->behavior < 40) {
            $state = State::firstOrCreate(['name' => 'Activa'], ['description' => 'La colmena está activa y saludable.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        if ($this->honey_stores > 80) {
            $state = State::firstOrCreate(['name' => 'Buenas reservas de miel'], ['description' => 'La colmena tiene abundantes reservas de miel.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }
        if ($this->pollen_stores > 80) {
            $state = State::firstOrCreate(['name' => 'Buenas reservas de polen'], ['description' => 'La colmena tiene abundantes reservas de polen.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }
        if ($this->brood_pattern > 80) {
            $state = State::firstOrCreate(['name' => 'Buena cría'], ['description' => 'El patrón de cría es excelente.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }
        if ($this->behavior < 20) {
            $state = State::firstOrCreate(['name' => 'Dócil'], ['description' => 'La colmena tiene un comportamiento muy dócil.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Anomalies
        if ($this->anomalies && $this->anomalies !== 'Sin anomalias') {
            $state = State::firstOrCreate(['name' => $this->anomalies], ['description' => 'Anomalía detectada: ' . $this->anomalies, 'type' => 'bad', 'category' => 'Anomalías']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Social States
        if ($this->social_states && $this->social_states !== 'Normal') {
            $type = ($this->social_states === 'Deriva') ? 'neutral' : 'bad';
            $state = State::firstOrCreate(['name' => $this->social_states], ['description' => 'Estado social: ' . $this->social_states, 'type' => $type, 'category' => 'Estados sociales']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Season States
        if ($this->season_states && $this->season_states !== 'Normal') {
            $type = ($this->season_states === 'Invernando') ? 'neutral' : 'good';
            $state = State::firstOrCreate(['name' => $this->season_states], ['description' => 'Estado de estación: ' . $this->season_states, 'type' => $type, 'category' => 'Estados de estación del año']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        // Admin States
        if ($this->admin_states && $this->admin_states !== 'Sin accion') {
            $state = State::firstOrCreate(['name' => $this->admin_states], ['description' => 'Acción de administración: ' . $this->admin_states, 'type' => 'neutral', 'category' => 'Estados de administración']);
            $statesToSync[$state->id] = ['cause' => $cause];
        }

        $hive->states()->sync($statesToSync);
    }
}
