<?php

use Illuminate\Database\Seeder;

class StoragesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storages = [
            ["id" => 1, "title" => "my Storage", "location" => "someWhere iela 341", "palete_capacity" => 530, "class" => "C"],
            ["id" => 2, "title" => "my Expensive Storage", "location" => "Riga, Riga iela 1", "palete_capacity" => 1300, "class" => "B"],
            ["id" => 3, "title" => "my Super Storage", "location" => "Riga, Liela iela 1", "palete_capacity" => 3000, "class" => "A"],
        ];

        App\Storage::insert($storages);

        $enterprise_storages = [
            ["enterprise_id" => 1, "storage_id" => 2],
            ["enterprise_id" => 2, "storage_id" => 2],
            ["enterprise_id" => 2, "storage_id" => 1],
            ["enterprise_id" => 2, "storage_id" => 3],
        ];

        DB::table("enterprise_storage")->insert($enterprise_storages);

    }
}
