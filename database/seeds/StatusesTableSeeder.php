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
        App\Status::create([
            "id" => 1,
            "name" => "Good"
        ]);

        App\Status::create([
            "id" => 2,
            "name" => "Normal"
        ]);

        App\Status::create([
            "id" => 3,
            "name" => "Bad"
        ]);
    }
}
