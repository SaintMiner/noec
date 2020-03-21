<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_storage', function (Blueprint $table) {
            $table->unsignedBigInteger("storage_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedSmallInteger("palete_amount")->default(0);
        });

        Schema::table("product_storage", function($table) {
            $table->primary(["storage_id", "product_id"]);
            $table->foreign("storage_id")->references("id")->on("storages")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_products');
    }
}
