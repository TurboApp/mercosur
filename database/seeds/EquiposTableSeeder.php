<?php

use Illuminate\Database\Seeder;

class EquiposTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 2; $i++) {
            App\Equipo::create([
                'nombre' => $faker->company,
                'descripcion' => $faker->realText( 200 , 2 ),
            ]);
        }
    }
}
