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
    }
}
