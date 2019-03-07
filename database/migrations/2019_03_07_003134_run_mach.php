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
            $table->integer('employee_id');
            $table->string('table_id');
            $table->string('mounter_id');
            $table->string('pos_id');
            $table->string('component_id');
            $table->string('order_id');
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
