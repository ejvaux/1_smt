<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->integer('line_id');
            $table->integer('feeder_id');
            $table->integer('mat_load_id')->nullable();
            $table->integer('usage')->nullable();
            $table->integer('reel_qty')->nullable();
            $table->integer('sn')->nullable();
            $table->integer('remaining_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_counts');
    }
}
