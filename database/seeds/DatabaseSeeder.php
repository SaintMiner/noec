<?php

use App\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            DepartmentsTableSeeder::class,
            EnterprisesTableSeeder::class,
            PositionsTableSeeder::class,
            StatusesTableSeeder::class,
            ResourcesTableSeeder::class,
            StoragesTableSeeder::class,
            ProductsTableSeeder::class,
        ]);
    }
}
