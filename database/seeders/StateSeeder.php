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
            ['name' => 'Huerfana', 'description' => 'La colmena no tiene reina.', 'type' => 'bad'],
            ['name' => 'Población baja', 'description' => 'La población de abejas es baja.', 'type' => 'bad'],
            ['name' => 'Reservas de miel bajas', 'description' => 'Las reservas de miel son bajas.', 'type' => 'bad'],
            ['name' => 'Reservas de polen bajas', 'description' => 'Las reservas de polen son bajas.', 'type' => 'bad'],
            ['name' => 'Agresiva', 'description' => 'La colmena es muy agresiva.', 'type' => 'bad'],
            ['name' => 'Enferma sin tratamiento', 'description' => 'La colmena está enferma y no está recibiendo tratamiento.', 'type' => 'bad'],
            ['name' => 'Enferma con tratamiento', 'description' => 'La colmena está enferma y está recibiendo tratamiento.', 'type' => 'neutral'],
            ['name' => 'Varroa', 'description' => 'Presencia de Varroa.', 'type' => 'bad'],
            ['name' => 'Loque Americana', 'description' => 'Presencia de Loque Americana.', 'type' => 'bad'],
            ['name' => 'Loque Europea', 'description' => 'Presencia de Loque Europea.', 'type' => 'bad'],
            ['name' => 'Polilla de la cera', 'description' => 'Presencia de Polilla de la cera.', 'type' => 'bad'],
            ['name' => 'Escarabajo de la colmena', 'description' => 'Presencia de Escarabajo de la colmena.', 'type' => 'bad'],
            ['name' => 'Nariz blanca', 'description' => 'Presencia de Nariz blanca.', 'type' => 'bad'],
            ['name' => 'Piojo de la abeja', 'description' => 'Presencia de Piojo de la abeja.', 'type' => 'bad'],
            ['name' => 'Acaro traqueal', 'description' => 'Presencia de Acaro traqueal.', 'type' => 'bad'],
        ];

        foreach ($states as $stateData) {
            State::firstOrCreate(['name' => $stateData['name']], $stateData);
        }
    }
}
