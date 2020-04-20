<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ["id" => 1, "name" => "Good", "color" => "Red"],
            ["id" => 2, "name" => "Normal", "color" => "Yellow"],
            ["id" => 3, "name" => "Bad", "color" => "Green"],
        ];
        App\Status::insert($statuses);
    }
}
