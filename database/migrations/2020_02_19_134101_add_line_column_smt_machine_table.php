<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineColumnSmtMachineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('smt_machines', function (Blueprint $table) {
            $table->integer('_line_id')->nullable()->after('machine_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('smt_machines', function (Blueprint $table) {
            $table->dropColumn([
                '_line_id'
                ]);
        });
    }
}
