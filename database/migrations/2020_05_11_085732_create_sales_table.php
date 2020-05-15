<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("enterprise_id");
            $table->decimal("discount", 8, 2);
            $table->enum("status", ["In progress", "Completed", "Canceled"]);
            $table->timestamps();
        });

        Schema::table("sales", function($table) {
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
