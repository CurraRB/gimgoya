<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Usuarios ---
        DB::table('usuarios')->insert([
            ['nombre' => 'Ana García',      'usuario' => 'ana',    'password' => '1234', 'rol' => 'monitor', 'especialidad' => 'Yoga',     'email' => null,                'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pedro Ruiz',      'usuario' => 'pedro',  'password' => '1234', 'rol' => 'monitor', 'especialidad' => 'Spinning',  'email' => null,                'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Carlos López',    'usuario' => 'carlos', 'password' => '1234', 'rol' => 'socio',   'especialidad' => null,        'email' => 'carlos@email.com',  'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María Sánchez',   'usuario' => 'maria',  'password' => '1234', 'rol' => 'socio',   'especialidad' => null,        'email' => 'maria@email.com',   'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Luis Martín',     'usuario' => 'luis',   'password' => '1234', 'rol' => 'socio',   'especialidad' => null,        'email' => 'luis@email.com',    'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Elena Torres',    'usuario' => 'elena',  'password' => '1234', 'rol' => 'socio',   'especialidad' => null,        'email' => 'elena@email.com',   'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jorge Díaz',      'usuario' => 'jorge',  'password' => '1234', 'rol' => 'socio',   'especialidad' => null,        'email' => 'jorge@email.com',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- Tipos de clase ---
        DB::table('tipos_clase')->insert([
            ['nombre' => 'Yoga',     'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pilates',  'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Spinning', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // IDs resultantes: ana=1, pedro=2 | yoga=1, pilates=2, spinning=3

        // --- Clases ---
        DB::table('clases')->insert([
            ['tipo_clase_id' => 1, 'monitor_id' => 1, 'fecha' => '2026-06-02', 'hora_inicio' => '09:00:00', 'hora_fin' => '10:00:00', 'aforo' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 1, 'monitor_id' => 1, 'fecha' => '2026-06-04', 'hora_inicio' => '18:00:00', 'hora_fin' => '19:00:00', 'aforo' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 2, 'monitor_id' => 1, 'fecha' => '2026-06-03', 'hora_inicio' => '10:30:00', 'hora_fin' => '11:30:00', 'aforo' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 2, 'monitor_id' => 1, 'fecha' => '2026-06-06', 'hora_inicio' => '17:00:00', 'hora_fin' => '18:00:00', 'aforo' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 3, 'monitor_id' => 2, 'fecha' => '2026-06-02', 'hora_inicio' => '07:00:00', 'hora_fin' => '08:00:00', 'aforo' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 3, 'monitor_id' => 2, 'fecha' => '2026-06-05', 'hora_inicio' => '19:00:00', 'hora_fin' => '20:00:00', 'aforo' => 6,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 3, 'monitor_id' => 2, 'fecha' => '2026-06-07', 'hora_inicio' => '08:00:00', 'hora_fin' => '09:00:00', 'aforo' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 1, 'monitor_id' => 2, 'fecha' => '2026-06-10', 'hora_inicio' => '11:00:00', 'hora_fin' => '12:00:00', 'aforo' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 2, 'monitor_id' => 2, 'fecha' => '2026-06-11', 'hora_inicio' => '16:00:00', 'hora_fin' => '17:00:00', 'aforo' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['tipo_clase_id' => 3, 'monitor_id' => 1, 'fecha' => '2026-06-12', 'hora_inicio' => '07:30:00', 'hora_fin' => '08:30:00', 'aforo' => 8,  'created_at' => now(), 'updated_at' => now()],
        ]);

        // --- Reservas ---
        // Clase 1 (Yoga Ana, aforo 10): 2/10
        // Clase 2 (Yoga Ana, aforo  5): 5/5 COMPLETA
        // Clase 3 (Pilates Ana, aforo 8): 1/8
        // Clase 4 (Pilates Ana, aforo 3): 3/3 COMPLETA
        // Clase 5 (Spinning Pedro, aforo 15): 2/15
        // Clase 6 (Spinning Pedro, aforo  6): 2/6
        // Clase 7 (Spinning Pedro, aforo  2): 2/2 COMPLETA
        // Clase 8 (Yoga Pedro, aforo 12): 2/12
        // Clase 9 (Pilates Pedro, aforo 4): 1/4
        // Clase 10 (Spinning Ana, aforo 8): 1/8
        DB::table('reservas')->insert([
            ['socio_id' => 3, 'clase_id' => 1,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Carlos → clase 1
            ['socio_id' => 4, 'clase_id' => 1,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // María  → clase 1
            ['socio_id' => 3, 'clase_id' => 2,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Carlos → clase 2
            ['socio_id' => 4, 'clase_id' => 2,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // María  → clase 2
            ['socio_id' => 5, 'clase_id' => 2,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Luis   → clase 2
            ['socio_id' => 6, 'clase_id' => 2,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Elena  → clase 2
            ['socio_id' => 7, 'clase_id' => 2,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Jorge  → clase 2
            ['socio_id' => 6, 'clase_id' => 3,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Elena  → clase 3
            ['socio_id' => 5, 'clase_id' => 4,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Luis   → clase 4
            ['socio_id' => 6, 'clase_id' => 4,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Elena  → clase 4
            ['socio_id' => 7, 'clase_id' => 4,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Jorge  → clase 4
            ['socio_id' => 3, 'clase_id' => 5,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Carlos → clase 5
            ['socio_id' => 5, 'clase_id' => 5,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Luis   → clase 5
            ['socio_id' => 4, 'clase_id' => 6,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // María  → clase 6
            ['socio_id' => 7, 'clase_id' => 6,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Jorge  → clase 6
            ['socio_id' => 3, 'clase_id' => 7,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Carlos → clase 7
            ['socio_id' => 4, 'clase_id' => 7,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // María  → clase 7
            ['socio_id' => 6, 'clase_id' => 8,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Elena  → clase 8
            ['socio_id' => 7, 'clase_id' => 8,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Jorge  → clase 8
            ['socio_id' => 5, 'clase_id' => 9,  'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // Luis   → clase 9
            ['socio_id' => 4, 'clase_id' => 10, 'estado' => 'activa', 'created_at' => now(), 'updated_at' => now()], // María  → clase 10
        ]);
    }
}
