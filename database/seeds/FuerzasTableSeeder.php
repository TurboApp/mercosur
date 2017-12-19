<?php

use Illuminate\Database\Seeder;

class FuerzasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 60 ; $i++) {
          $fuerza=App\FuerzaTarea::create([
            'nombre' => $faker->name,
            'categoria' => $faker->randomElement($array = array ('Montacarguista','Montacarga','Auxiliar de Patio')),
          ]);
        }
    }
}
