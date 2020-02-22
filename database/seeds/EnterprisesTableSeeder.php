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
        App\Enterprise::create([
            "id" => 1,
            "name" => "First Enterprise (not) ever"
        ]);

        App\Enterprise::create([
            "id" => 2,
            "name" => "Trikster"
        ]);
    }
}
