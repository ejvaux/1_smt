<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIndexPcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->dropIndex(['serial_number']);
            $table->dropIndex(['jo_id']);
            $table->dropIndex(['div_process_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['exported']);
            $table->dropIndex(['work_order']);
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
            $table->index('serial_number');
            $table->index('jo_id');
            $table->index('div_process_id');
            $table->index('type');
            $table->index('exported');
            $table->index('work_order');
        });
    }
}
