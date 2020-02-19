<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Position::create([
            "id" => 1,
            "name" => "High"
        ]);

        App\Position::create([
            "id" => 2,
            "name" => "Medium"
        ]);

        App\Position::create([
            "id" => 3,
            "name" => "Low"
        ]);
    }
}
