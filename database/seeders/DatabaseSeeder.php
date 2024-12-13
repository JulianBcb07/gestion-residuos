<?php

namespace Database\Seeders;

use App\Models\Subproducto;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Llama al seeder de roles y permisos para asegurarse de que se creen
        $this->call(RolesAndPermissionsSeeder::class);

        User::factory()->superusuario()->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // O bien, puedes agregar la lógica aquí mismo:
        $subproductos = ['Papel y Cartón', 'Plástico PET', 'Plastico Rigido', 'Vidrio', 'Aluminio', 'Metal', 'Orgánicos', 'No valorizables (Sanitarios y emplayes)', 'Manejo Especial', 'Peligrosos'];

        foreach ($subproductos as $nombre) {
            Subproducto::create(['nombre' => $nombre]);
        }
    }
}
