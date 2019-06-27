<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexPcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->index('serial_number');
            $table->index('jo_id');
            $table->index('div_process_id');
            $table->index('type');
            $table->index('exported');
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
            $table->dropIndex(['serial_number']);
            $table->dropIndex(['jo_id']);
            $table->dropIndex(['div_process_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['exported']);
        });
    }
}
