<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(userSeeder::class);
        $this->call(kategoriSeeder::class);
        $this->call(provinsiSeeder::class);
        $this->call(kotaSeeder::class);
        $this->call(satuanSeeder::class);
    }
}
