<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line');
            $table->string('pcb_pn');
            $table->string('program');
            $table->string('reel_id');
            $table->string('component_pn');
            $table->datetime('feed_time');
            $table->integer('reel_qty');
            $table->string('usage');
            $table->integer('target_qty');
            $table->integer('sys_qty');            
            $table->datetime('date');
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
        Schema::dropIfExists('material_reports');
    }
}
