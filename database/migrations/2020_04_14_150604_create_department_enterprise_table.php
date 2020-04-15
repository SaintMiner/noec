<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_enterprise', function (Blueprint $table) {
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("enterprise_id");
            $table->unsignedBigInteger("manager")->nullable();
        });

        Schema::table("department_enterprise", function($table) {
            $table->primary(["department_id", "enterprise_id"]);
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
            $table->foreign("department_id")->references("id")->on("departments")->onDelete("cascade");
            $table->foreign("manager")->references("id")->on("resources")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_enterprise');
    }
}
