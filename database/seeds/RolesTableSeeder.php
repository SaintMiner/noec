<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ["id" => 1, "name" => "Admin", "slug" => "admin"],
            ["id" => 2, "name" => "Warehouse Manager", "slug" => "wh_manager"],
            ["id" => 3, "name" => "Accountant", "slug" => "accountent"],
            ["id" => 4, "name" => "HR Manager", "slug" => "hr_manager"],
            ["id" => 5, "name" => "Director", "slug" => "director"],
            ["id" => 6, "name" => "Order manager", "slug" => "or_manager"],
        ];
        App\Role::insert($roles);

        $role_user = [
            ["user_id" => 1, "role_id" => 1],
            ["user_id" => 1, "role_id" => 2],
            ["user_id" => 1, "role_id" => 3],
            ["user_id" => 1, "role_id" => 4],
            ["user_id" => 1, "role_id" => 5],
        ];

        DB::table("role_user")->insert($role_user);
    }
}
