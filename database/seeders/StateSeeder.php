<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            // Indicadores de Inspección (Negativo)
            ['name' => 'Huerfana', 'description' => 'La colmena no tiene reina.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Población baja', 'description' => 'La población de abejas es baja.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Reservas de miel bajas', 'description' => 'Las reservas de miel son bajas.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Reservas de polen bajas', 'description' => 'Las reservas de polen son bajas.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Agresiva', 'description' => 'La colmena es muy agresiva.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Enferma sin tratamiento', 'description' => 'La colmena está enferma y no está recibiendo tratamiento.', 'type' => 'bad', 'category' => 'Indicadores de Inspección (Negativo)'],
            ['name' => 'Enferma con tratamiento', 'description' => 'La colmena está enferma y está recibiendo tratamiento.', 'type' => 'neutral', 'category' => 'Indicadores de Inspección (Negativo)'],

            // Plagas y Enfermedades
            ['name' => 'Varroa', 'description' => 'Presencia de Varroa.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Loque Americana', 'description' => 'Presencia de Loque Americana.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Loque Europea', 'description' => 'Presencia de Loque Europea.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Polilla de la cera', 'description' => 'Presencia de Polilla de la cera.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Escarabajo de la colmena', 'description' => 'Presencia de Escarabajo de la colmena.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Nariz blanca', 'description' => 'Presencia de Nariz blanca.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Piojo de la abeja', 'description' => 'Presencia de Piojo de la abeja.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],
            ['name' => 'Acaro traqueal', 'description' => 'Presencia de Acaro traqueal.', 'type' => 'bad', 'category' => 'Plagas y Enfermedades'],

            // Indicadores de Inspección (Positivo)
            ['name' => 'Óptima', 'description' => 'La colmena está en condiciones óptimas.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],
            ['name' => 'Activa', 'description' => 'La colmena está activa y saludable.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],
            ['name' => 'Buenas reservas de miel', 'description' => 'La colmena tiene abundantes reservas de miel.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],
            ['name' => 'Buenas reservas de polen', 'description' => 'La colmena tiene abundantes reservas de polen.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],
            ['name' => 'Buena cría', 'description' => 'El patrón de cría es excelente.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],
            ['name' => 'Dócil', 'description' => 'La colmena tiene un comportamiento muy dócil.', 'type' => 'good', 'category' => 'Indicadores de Inspección (Positivo)'],

            // Anomalías
            ['name' => 'Enjambrazon', 'description' => 'La colmena está mostrando signos de enjambrazón.', 'type' => 'bad', 'category' => 'Anomalías'],
            ['name' => 'Zanganera', 'description' => 'La colmena se ha vuelto zanganera.', 'type' => 'bad', 'category' => 'Anomalías'],

            // Estados sociales
            ['name' => 'Pillaje', 'description' => 'La colmena está siendo pillada por otras abejas.', 'type' => 'bad', 'category' => 'Estados sociales'],
            ['name' => 'Pillera', 'description' => 'La colmena está pillando a otras.', 'type' => 'bad', 'category' => 'Estados sociales'],
            ['name' => 'Deriva', 'description' => 'Se observa deriva de abejas de otras colmenas.', 'type' => 'neutral', 'category' => 'Estados sociales'],

            // Estados de estación del año
            ['name' => 'Expansion', 'description' => 'La colmena está en fase de expansión.', 'type' => 'good', 'category' => 'Estados de estación del año'],
            ['name' => 'Produccion', 'description' => 'La colmena está en plena producción de miel.', 'type' => 'good', 'category' => 'Estados de estación del año'],
            ['name' => 'Almacenamiento', 'description' => 'La colmena está almacenando reservas para el invierno.', 'type' => 'good', 'category' => 'Estados de estación del año'],
            ['name' => 'Invernando', 'description' => 'La colmena está invernando.', 'type' => 'neutral', 'category' => 'Estados de estación del año'],

            // Estados de administración
            ['name' => 'Revision', 'description' => 'La colmena está programada para revisión.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Mantenimiento', 'description' => 'Se está realizando mantenimiento en la colmena.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Alimentacion artificial', 'description' => 'Se está aplicando alimentación artificial.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Union', 'description' => 'La colmena está en proceso de ser unida con otra.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Division', 'description' => 'La colmena ha sido dividida o está en proceso de división.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Crianza de reynas', 'description' => 'Se está utilizando la colmena para la crianza de reinas.', 'type' => 'neutral', 'category' => 'Estados de administración'],
            ['name' => 'Sin uso', 'description' => 'La colmena no está en uso.', 'type' => 'neutral', 'category' => 'Estados de administración'],
        ];

        foreach ($states as $stateData) {
            State::firstOrCreate(['name' => $stateData['name']], $stateData);
        }
    }
}
