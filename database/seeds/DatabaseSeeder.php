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
            DepartmentsTableSeeder::class,
            PositionsTableSeeder::class,
            EnterprisesTableSeeder::class,
            StatusesTableSeeder::class,
            ResourcesTableSeeder::class,
            StoragesTableSeeder::class,
            ProductsTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
