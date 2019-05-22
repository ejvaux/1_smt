<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExportColumnPcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->string('RESULT')->nullable()->after('defect');
            $table->string('ERROR_CODE')->nullable()->after('RESULT');
            $table->string('PROCESS_NAME')->nullable()->after('ERROR_CODE');
            $table->string('MACHINE')->nullable()->after('PROCESS_NAME');            
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
                'RESULT',
                'ERROR_CODE',
                'PROCESS_NAME',
                'MACHINE'
                ]);
        });
    }
}
