<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatSnCompsArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mat_sn_comps_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->integer('line_id');
            $table->integer('mat_comp_id')->nullable();
            $table->integer('component_id');
            $table->string('RID');
            $table->longText('sn')->nullable();            
            $table->timestamps();            
            $table->index('model_id');
            $table->index('line_id');
            $table->index('component_id');
            $table->index('RID');
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
        Schema::dropIfExists('mat_sn_comps_archives');
    }
}
