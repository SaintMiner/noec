<?php

use Illuminate\Database\Seeder;

class EnterprisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enterprises = [
            ["id" => 1, "title" => "First Enterprise (not) ever", "registration_number" => 41233742426, "location" => "Ventspils, Kaķu iela 1"],
            ["id" => 2, "title" => "Trikster", "registration_number" => 41233512426, "location" => "Rīga, Kaķu iela 1"]
        ];
        App\Enterprise::insert($enterprises);

        $department_enterprise = [
            ["enterprise_id" => 1, "department_id" => 1],
            ["enterprise_id" => 2, "department_id" => 2],
            ["enterprise_id" => 2, "department_id" => 1],
            ["enterprise_id" => 1, "department_id" => 2],
        ];
        DB::table("department_enterprise")->insert($department_enterprise);

        $enterprise_position = [
            ["enterprise_id" => 1, "position_id" => 1],
            ["enterprise_id" => 2, "position_id" => 2],
            ["enterprise_id" => 2, "position_id" => 1],
            ["enterprise_id" => 1, "position_id" => 2],
            ["enterprise_id" => 2, "position_id" => 3],
            ["enterprise_id" => 1, "position_id" => 3],
        ];
        DB::table("enterprise_position")->insert($enterprise_position);
    }
}
