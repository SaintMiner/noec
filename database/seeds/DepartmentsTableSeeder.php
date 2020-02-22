<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Department::create([
            "id" => 1,
            "name" => "Dark"
        ]);

        App\Department::create([
            "id" => 2,
            "name" => "Light"
        ]);
    }
}
