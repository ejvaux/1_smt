<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsageDecimalSmtFeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('smt_feeders', function (Blueprint $table) {
            $table->decimal('usage', 4, 1)->change();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('smt_feeders', function (Blueprint $table) {
            $table->integer('usage')->change();            
        });
    }
}
