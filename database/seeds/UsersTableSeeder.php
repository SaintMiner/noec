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
            ["id" => 1, "name" => "Admin", "email" => "admin@admin.am", "password" => bcrypt("Password123")],
        ];

        App\User::insert($users);
    }
}
