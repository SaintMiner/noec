<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $humanResources = [
            [
                "id" => 1,
                "name" => "Admin",
                "surname" => "Account",
                "department_id" => 2,
                "position_id" => 2,
                "status_id" => 2,
                "enterprise_id" => 2,
            ],
            [
                "id" => 2,
                "name" => "Mike",
                "surname" => "Larryson",
                "department_id" => 1,
                "position_id" => 1,
                "status_id" => 1,
                "enterprise_id" => 1,
            ],
            [
                "id" => 3,
                "name" => "Donny",
                "surname" => "Pony",
                "department_id" => 1,
                "position_id" => 3,
                "status_id" => 3,
                "enterprise_id" => 1,
            ],
            [
                "id" => 4,
                "name" => "Joheph",
                "surname" => "Jhostar",
                "department_id" => 2,
                "position_id" => 3,
                "status_id" => 2,
                "enterprise_id" => 2,
            ],
            [
                "id" => 5,
                "name" => "Jhonatan",
                "surname" => "Jhostar",
                "department_id" => 2,
                "position_id" => 1,
                "status_id" => 1,
                "enterprise_id" => 1,
            ],
            [
                "id" => 6,
                "name" => "Koyo",
                "surname" => "Jhotaro",
                "department_id" => 1,
                "position_id" => 2,
                "status_id" => 1,
                "enterprise_id" => 2,
            ],
            [
                "id" => 7,
                "name" => "Giorno",
                "surname" => "Ghovano",
                "department_id" => 1,
                "position_id" => 1,
                "status_id" => 1,
                "enterprise_id" => 1,
            ],
            [
                "id" => 8,
                "name" => "No",
                "surname" => "Idea",
                "department_id" => 1,
                "position_id" => 2,
                "status_id" => 3,
                "enterprise_id" => 2,
            ]
        ];
        
        App\Resource::insert($humanResources);

        
    }
}
