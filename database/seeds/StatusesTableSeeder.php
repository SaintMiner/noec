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
            ["id" => 1, "name" => "Good"],
            ["id" => 2, "name" => "Normal"],
            ["id" => 3, "name" => "Bad"]
        ];
        App\Status::insert($statuses);
    }
}
