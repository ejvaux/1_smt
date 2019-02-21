<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Errorlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('errorlist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('error_code')->unique();
            $table->string('error_type');
            $table->string('error_level');
            $table->string('error_desc');
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
