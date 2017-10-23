<?php

use Illuminate\Database\Seeder;

class AgentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

            for($i = 0; $i < 10; $i++) {
                App\Agente::create([
                    'nombre' => $faker->company,
                    'nombre_corto' => $faker->companySuffix,
                    'email' => $faker->email,
                    'telefono' => $faker->tollFreePhoneNumber,
                    'celular' => $faker->e164PhoneNumber,
                    'direccion' => $faker->address,
                    'rfc' => strtoupper($faker->word(2)) . $faker->randomNumber(5) ,
                    'ciudad' => $faker->city,
                    'codigo_postal' => $faker->postcode,
                ]);
            }
    }
}
