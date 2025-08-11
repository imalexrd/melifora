<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
