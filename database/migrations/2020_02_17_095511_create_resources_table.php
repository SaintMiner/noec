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
            $table->string("name", 50);
            $table->string("surname", 50);

            $table->unsignedBigInteger("department_id")->nullable();
            $table->unsignedBigInteger("position_id")->nullable();
            $table->unsignedBigInteger("status_id")->nullable();
            $table->unsignedBigInteger("enterprise_id")->nullable();
            
            $table->boolean("job_candidated")->default(0);

            $table->timestamps();
            
        });

        Schema::table("resources", function($table) {
            $table->foreign("department_id")->references("id")->on("departments")->onDelete("set null");
            $table->foreign("position_id")->references("id")->on("positions")->onDelete("set null");
            $table->foreign("status_id")->references("id")->on("statuses")->onDelete("set null");
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("set null");
        });

        Schema::table("users", function($table) {
            $table->foreign("resource_id")->references("id")->on("resources")->onDelete("cascade");
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
