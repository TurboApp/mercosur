<?php

use Illuminate\Database\Seeder;

class clientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
            for($i = 0; $i < 100; $i++) {
                App\Cliente::create([
                    'nombre' => $faker->firstNameMale ." ".$faker->lastName,
                    'nombre_corto' => $faker->firstNameMale,
                    'email' => $faker->email,
                    'telefono' => $faker->tollFreePhoneNumber,
                    'celular' => $faker->e164PhoneNumber,
                    'direccion' => $faker->address,
                    'rfc' => $faker->text(15),
                    'ciudad' => $faker->city,
                    'codigo_postal' => $faker->postcode,
                ]);
            }
    }
}
