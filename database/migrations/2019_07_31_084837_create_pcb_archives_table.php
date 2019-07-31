<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcbArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcb_archive', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->integer('jo_id');
            $table->string('jo_number');
            $table->integer('lot_id');
            $table->integer('division_id');
            $table->integer('line_id');
            $table->integer('div_process_id');
            $table->boolean('type');
            $table->integer('employee_id');
            $table->integer('shift')->nullable();
            $table->integer('mat_comp_id')->nullable();
            $table->string('heat');
            $table->string('defect');
            $table->string('PDLINE_NAME')->nullable();
            $table->string('RESULT')->nullable();
            $table->string('ERROR_CODE')->nullable();
            $table->string('PROCESS_NAME')->nullable();
            $table->string('MACHINE')->nullable();
            $table->boolean('exported')->default(0);
            $table->timestamps();
            $table->string('SAP_TRANSFER_STATUS')->nullable();
            $table->index('serial_number');
            $table->index('jo_id');
            $table->index('div_process_id');
            $table->index('type');
            $table->index('exported');
            $table->index('SAP_TRANSFER_STATUS');
            $table->unique(['serial_number','div_process_id','type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pcb_archive');
    }
}
