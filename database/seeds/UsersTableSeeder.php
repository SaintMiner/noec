<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ["id" => 1, "username" => "Admin", "password" => bcrypt("Password123"), "resource_id" => 1],
        ];

        App\User::insert($users);
    }
}
