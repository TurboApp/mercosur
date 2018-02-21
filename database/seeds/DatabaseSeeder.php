<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(perfilesTableSeeder::class);
        $this->call(EquiposTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(clientesTableSeeder::class);
        $this->call(AgentesTableSeeder::class);
        $this->call(TransportesTableSeeder::class);
        $this->call(FuerzasTableSeeder::class);
        //$this->call(DescargasDataSeeder::class);

    }
}
