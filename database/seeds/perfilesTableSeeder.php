<?php

use Illuminate\Database\Seeder;

class perfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        App\Perfil::create([
            'id' => 1,
            'perfil' => "admin",
            'Descripcion' => "Administrador",
        ]);

        App\Perfil::create([
            'id' => 2,
            'perfil' => "directivo",
            'Descripcion' => "Directivo",
        ]);

        App\Perfil::create([
            'id' => 3,
            'perfil' => "go",
            'Descripcion' => "Gerente Operativo",
        ]);

        App\Perfil::create([
            'id' => 4,
            'perfil' => "trafico",
            'Descripcion' => "Trafico",
        ]);

        App\Perfil::create([
            'id' => 5,
            'perfil' => "coordinador",
            'Descripcion' => "Coordinador de supervisores",
        ]);

        App\Perfil::create([
            'id' => 6,
            'perfil' => "supervisor",
            'Descripcion' => "Supervisor de maniobra",
        ]);
        
    }
}
