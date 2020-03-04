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
        $departments = [
            ["id" => 1, "name" => "Dark"],
            ["id" => 2, "name" => "Light"]
        ];
        App\Department::insert($departments);

    }
}
