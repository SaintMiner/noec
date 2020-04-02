<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_shipping', function (Blueprint $table) {
            $table->unsignedBigInteger("shipping_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedSmallInteger("pallete_count");
        });

        Schema::table("product_shipping", function($table) {
            $table->primary(["shipping_id", "product_id"]);
            $table->foreign("shipping_id")->references("id")->on("shippings")->onDelete("cascade");
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
        Schema::dropIfExists('product_shipping');
    }
}
