<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('error_mat_loading', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('mounter_id')->nullable();
            $table->integer('pos_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('component_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->string('ErrorType')->nullable();
            $table->string('ReelInfo')->nullable();
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
        Schema::dropIfExists('error_mat_loading');
    }
}
