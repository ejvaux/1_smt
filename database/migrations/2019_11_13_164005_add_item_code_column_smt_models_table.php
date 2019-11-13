<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemCodeColumnSmtModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('smt_models', function (Blueprint $table) {
            $table->string('item_code')->nullable()->after('program_name');
            $table->string('pcb_code')->nullable()->after('item_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('smt_models', function (Blueprint $table) {
            $table->dropColumn([
                'item_code',
                'pcb_code'
                ]);
        });
    }
}
