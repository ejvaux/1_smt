<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Scanrecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scanrecord', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prodline_id');
            $table->string('user_id');
            $table->string('error_id')->nullable();
            $table->string('process_id');
            $table->string('machine_id')->nullable();
            $table->string('serial_number');
            $table->string('scan_result');
            $table->string('scan_type');
            $table->string('SapPlanID');
            $table->string('SapJONum');
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
        Schema::dropIfExists('errorlist');
    }
}
