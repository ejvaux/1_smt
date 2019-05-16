<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->integer('jo_id')->after('serial_number');
            $table->string('jo_number')->after('jo_id');
            $table->integer('lot_id')->after('jo_number');
            $table->integer('division_id')->after('lot_id');
            $table->integer('line_id')->after('division_id');
            $table->integer('div_process_id')->after('line_id');
            $table->boolean('type')->after('div_process_id');
            $table->integer('employee_id')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->dropColumn([
                'jo_id',
                'jo_number',
                'lot_id',
                'division_id',
                'line_id',
                'div_process_id',
                'type',
                'employee_id'
                ]);
        });
    }
}
