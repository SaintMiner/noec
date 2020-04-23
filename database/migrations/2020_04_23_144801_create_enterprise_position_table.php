<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterprisePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_position', function (Blueprint $table) {
            $table->unsignedBigInteger("enterprise_id");
            $table->unsignedBigInteger("position_id");
        });

        Schema::table("enterprise_position", function($table) {
            $table->primary(["position_id", "enterprise_id"]);
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
            $table->foreign("position_id")->references("id")->on("positions")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_position');
    }
}
