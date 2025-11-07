<?php

namespace Database\Seeders; // namespace se utiliza para organizar y agrupar clases, interfaces, funciones y constantes relacionadas, evitando conflictos de nombres entre diferentes componentes

use App\Models\User; /* carga el modelo de la tabla */
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder // los seeders se utilizan para poblar la base de datos con datos de prueba o iniciales
{
    use WithoutModelEvents;

    // Inicializar la base de datos de la aplicación.
    public function run(): void // void significa que no devuelve nada
    {                           // run() es el metodo que ejecuta
        // User::factory(10)->create();

        User::factory()->create([ /* metodo que genera datos. Aqui crea y guarda un usuario real en la bbdd */
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
