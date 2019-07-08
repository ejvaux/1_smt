<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatCompsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_comps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->integer('line_id');
            $table->longText('materials')->nullable();
            $table->timestamps();
            $table->index('model_id');
            $table->index('line_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mat_comps');
    }
}
