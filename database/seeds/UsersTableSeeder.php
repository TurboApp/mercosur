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
        for($i = 0; $i < 10; $i++) {
            App\User::create([
                'nombre' => $faker->name,
                'apellido' => $faker->lastName,
                'email' => $faker->email,
                'direccion' => $faker->address,
                'telefono' => $faker->tollFreePhoneNumber,
                'celular' => $faker->e164PhoneNumber,
                'url_avatar' => $faker->imageUrl( 300, 300 ),
                'user' => $faker->userName,
                'password' => bcrypt('secret'),
                //'password' => 'secret',
                'perfil_id' => $faker->numberBetween(1, 6)
            ]);
        }
    }
}
