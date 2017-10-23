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
            'apellido' => $faker->lastName,
            'direccion' => $faker->address,
            'telefono' => $faker->tollFreePhoneNumber,
            'celular' => $faker->e164PhoneNumber,
            'categoria' => $faker->randomElement($array = array ('Montacarguista','Montacarga','Auxiliria de Patio')),
          ]);
        }
    }
}
