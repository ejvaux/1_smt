<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefectMatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defect_mats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pcb_id');
            $table->integer('division_id');
            $table->integer('defect_id');
            $table->string('defected_at');
            $table->integer('process_id')->nullable();
            $table->integer('employee_id');
            $table->integer('line_id');
            $table->integer('shift');
            $table->boolean('repair');
            $table->text('remarks')->nullable();
            $table->integer('repair_by')->nullable();
            $table->string('repaired_at')->nullable();
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
        Schema::dropIfExists('defect_mats');
    }
}
