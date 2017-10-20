<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 60; $i++) {
            
            $user = App\User::create([
                'nombre' => $faker->name,
                'apellido' => $faker->lastName,
                'email' => $faker->email,
                'direccion' => $faker->address,
                'telefono' => $faker->tollFreePhoneNumber,
                'celular' => $faker->e164PhoneNumber,
                'url_avatar' => '',
                'user' => $faker->userName,
                'password' => bcrypt('secret'),
                'perfil_id' => $faker->numberBetween(1, 6)
            ]);
            
        }
    }
}
