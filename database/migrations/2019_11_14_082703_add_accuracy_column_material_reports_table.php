<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccuracyColumnMaterialReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_reports', function (Blueprint $table) {
            $table->date('date')->change();
            $table->integer('usage')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_reports', function (Blueprint $table) {            
            $table->datetime('date')->change();            
            $table->string('usage');
        });
    }
}
