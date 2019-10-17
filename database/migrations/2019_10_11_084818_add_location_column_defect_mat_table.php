<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationColumnDefectMatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defect_mats', function (Blueprint $table) {
            $table->json('d_locations')->nullable()->after('defect_type_id');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defect_mats', function (Blueprint $table) {
            $table->dropColumn(['d_locations']);
        });
    }
}
