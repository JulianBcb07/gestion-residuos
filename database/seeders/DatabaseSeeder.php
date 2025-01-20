<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Subproducto;
use App\Models\User;
use App\Models\Zona;
use App\Models\ZonasAreas;
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
            'name' => 'AdministradorITSVA',
            'email' => 'gestionderesiduos@valladolid.tecnm.mx',
            'password' => bcrypt('password'),
        ]);

        // O bien, puedes agregar la lógica aquí mismo:
        $subproductos = ['Papel y Cartón', 'Plástico PET', 'Plastico Rigido', 'Vidrio', 'Aluminio', 'Metal', 'Orgánicos', 'No valorizables (Sanitarios y emplayes)', 'Manejo Especial', 'Peligrosos'];

        foreach ($subproductos as $nombre) {

            Subproducto::create(['nombre' => $nombre]);
        }

        // // Crear areas de la universidad
        // $areas = [
        //     'A. Administrativa (Oficinas)',
        //     'Biblioteca y centro de copiado',
        //     'Salones',
        //     'Sanitarios',
        //     'Estaciones de Basura (Pasillos)',
        //     'Centros de Cómputo',
        //     'Talleres',
        //     'Laboratorio Multidisiplinario',
        //     'Almacén',
        //     'Sala de Juntas',
        //     'Auditorio',
        //     'Sala de usos Múltiples',
        //     'Cubiculos de Docentes',
        // ];

        // foreach ($areas as $nombre) {
        //     Area::create(['nombre' => $nombre]);
        // }


        // Crear zonas de la universidad

        // $zonas = [
        //     'Zona 1. Eficios A, B y M',
        //     'Zona 2. Edificios C, E, F, K, N, Q y L',
        //     'Zona 3. Edificios D, I, J y P',
        //     'Zona 4. Edificios U y R',
        //     'Zona 5. Edificios H1 y O',
        //     'Zona 6. Edificios H2 y G',
        // ];

        // foreach ($zonas as $nombre) {
        //     Zona::create(['nombre' => $nombre]);
        // }
    }
}
