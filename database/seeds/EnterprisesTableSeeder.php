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
            ["id" => 1, "title" => "First Enterprise (not) ever", "location" => "Ventspils, Kaķu iela 1"],
            ["id" => 2, "title" => "Trikster", "location" => "Rīga, Kaķu iela 1"]
        ];
        App\Enterprise::insert($enterprises);
    }
}
