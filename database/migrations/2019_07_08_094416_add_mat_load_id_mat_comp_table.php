<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMatLoadIdMatCompTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mat_comps', function (Blueprint $table) {
            $table->integer('mat_load_id')->nullable()->after('line_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mat_comps', function (Blueprint $table) {
            $table->dropColumn([
                'mat_load_id'
                ]);
        });
    }
}
