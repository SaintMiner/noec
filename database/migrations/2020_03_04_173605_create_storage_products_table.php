<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_products', function (Blueprint $table) {
            $table->unsignedBigInteger("storage_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedSmallInteger("palete_amount");
        });

        Schema::table("storage_products", function($table) {
            $table->primary(["storage_id", "product_id"]);
            $table->foreign("storage_id")->references("id")->on("storages");
            $table->foreign("product_id")->references("id")->on("products");
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
