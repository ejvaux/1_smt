<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsageColumnSmtFeedersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('smt_feeders', function (Blueprint $table) {
            $table->integer('usage')->after('pos_id');            
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
            $table->dropColumn([
                'usage',
                ]);
        });
    }
}
