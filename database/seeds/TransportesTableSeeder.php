<?php

use Illuminate\Database\Seeder;

class TransportesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
            for($i = 0; $i < 88; $i++) {
                App\LineasTransporte::create([
                    'nombre' => $faker->company,
                    'nombre_corto' => $faker->companySuffix,
                    'tipo'=> $faker->randomElement($array = array ('Nacional','Extrangero')),
                    'email' => $faker->email,
                    'telefono' => $faker->tollFreePhoneNumber,
                    'celular' => $faker->e164PhoneNumber,
                    'direccion' => $faker->address,
                    'rfc' => 'RFC' . $faker->numberBetween(1000,9000) ,
                    'codigo_postal' => $faker->postcode,
                    'ciudad' => $faker->city,
                    'pais' => $faker->country,
                ]);
            }
    }
}
