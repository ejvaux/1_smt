<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('jo_id');
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('closed_by')->nullable();
            $table->integer('qc_status')->default(0);
            $table->integer('checked_by')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('closed_at')->nullable();
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
        Schema::dropIfExists('lot');
    }
}
