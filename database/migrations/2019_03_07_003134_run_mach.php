<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RunMach extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('running_mach', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id');
            $table->integer('model_id');
            $table->integer('table_id');
            $table->integer('mounter_id');
            $table->integer('pos_id');
            $table->integer('order_id')->nullable();
            $table->integer('component_id');
            $table->integer('employee_id');
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
        //
        Schema::dropIfExists('running_mach');
    }
}
