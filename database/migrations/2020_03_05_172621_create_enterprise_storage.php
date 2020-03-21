<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_storage', function (Blueprint $table) {
            $table->unsignedBigInteger("enterprise_id");
            $table->unsignedBigInteger("storage_id");
        });

        Schema::table("enterprise_storage", function($table) {
            $table->primary(["enterprise_id", "storage_id"]);
            $table->foreign("enterprise_id")->references("id")->on("enterprises")->onDelete("cascade");
            $table->foreign("storage_id")->references("id")->on("storages")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_storage');
    }
}
