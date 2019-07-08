<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifiedMatSnCompTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mat_sn_comps', function (Blueprint $table) {
            $table->integer('mat_comp_id')->nullable()->after('line_id');
            $table->index('mat_comp_id');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::table('mat_sn_comps', function (Blueprint $table) {
            $table->dropColumn([
                'mat_comp_id'
                ]);
        });
    }
}
