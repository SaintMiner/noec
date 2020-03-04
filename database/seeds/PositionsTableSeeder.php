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
        $positions = [
            ["id" => 1, "name" => "High"],
            ["id" => 2, "name" => "Medium"],
            ["id" => 3, "name" => "Low"]
        ];
        App\Position::insert($positions);
    }
}
