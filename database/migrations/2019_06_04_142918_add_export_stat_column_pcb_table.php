<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExportStatColumnPcbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcb', function (Blueprint $table) {
            $table->boolean('exported')->default(0)->after('MACHINE');
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
                'exported'
                ]);
        });
    }
}
