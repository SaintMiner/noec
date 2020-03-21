<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_product', function (Blueprint $table) {
            $table->unsignedBigInteger("enterprise_id");
            $table->unsignedBigInteger("product_id");
            $table->decimal("sale_price", 8, 2);
            $table->unsignedSmallInteger("amount")->default(0);
        });

        Schema::table("enterprise_product", function($table) {
            $table->primary(["enterprise_id", "product_id"]);
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
        Schema::dropIfExists('enterprise_products');
    }
}
