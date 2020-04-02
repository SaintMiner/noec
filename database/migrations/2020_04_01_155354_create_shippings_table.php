<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("enterprise_id")->nullable();
            $table->unsignedBigInteger("storage_id");
            $table->enum("type", ["Replenish Storage", "Replenish Enterprise"]);
            $table->enum("status", ["In progress", "Completed", "Canceled"]);
            $table->timestamps();
        });

        Schema::table("shippings", function($table) {
            $table->foreign("storage_id")->references("id")->on("storages")->onDelete("cascade");
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
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
        Schema::dropIfExists('shippings');
    }
}
