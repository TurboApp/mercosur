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
        App\User::create([
            'nombre' => 'Administrador',
            'apellido' => 'Admin',
            'email' => 'chd2al@gmail.com',
            'direccion' => '',
            'telefono' => '',
            'celular' => '9622594671',
            'url_avatar' => '',
            'user' => 'admin',
            'password' => bcrypt('secret'),
            'perfil_id' => 1,
            'equipo_id' => ''
        ]);
        //$faker = Faker\Factory::create();
        
        //Admin
        // for($i = 0; $i < 1; $i++) {
        //     App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'admin'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 1,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
        // }    
        
        //Directores
        // for($i = 0; $i < 3; $i++) {
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'directivo'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 2,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
            
        // }

        //Gerente operativo
        // for($i = 0; $i < 3; $i++) {
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'gerente'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 3,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
        // }

        //Trafico
        // for($i = 0; $i < 5; $i++) {
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'trafico'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 4,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
            
        // }

        // //Coordinador
        // for($i = 0; $i < 4; $i++) {
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'coordinador'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 5,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
        // }

        // //Supervisores
        // for($i = 0; $i < 10; $i++) {
        //     $user = App\User::create([
        //         'nombre' => $faker->name,
        //         'apellido' => $faker->lastName,
        //         'email' => $faker->email,
        //         'direccion' => $faker->address,
        //         'telefono' => $faker->tollFreePhoneNumber,
        //         'celular' => $faker->e164PhoneNumber,
        //         'url_avatar' => '',
        //         'user' => 'supervisor'.$i,
        //         'password' => bcrypt('secret'),
        //         'perfil_id' => 6,
        //         'equipo_id' =>$faker->numberBetween(1, 2)
        //     ]);
            
        // }

    }
}
