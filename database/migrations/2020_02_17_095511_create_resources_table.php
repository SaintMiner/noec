<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("surname");

            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("position_id");
            $table->unsignedBigInteger("status_id");
            $table->unsignedBigInteger("enterprise_id");

            $table->timestamps();
            
        });

        Schema::table("resources", function($table) {
            $table->foreign("department_id")->references("id")->on("departments")->onDelete("cascade");
            $table->foreign("position_id")->references("id")->on("positions")->onDelete("cascade");
            $table->foreign("status_id")->references("id")->on("statuses")->onDelete("cascade");
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
        });

        Schema::table("departments", function($table) {
            $table->foreign("manager_id")->references("id")->on("resources");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
