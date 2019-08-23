<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtyColumnLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lot', function (Blueprint $table) {
            $table->integer('qty')->default(0)->after('closed_by');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lot', function (Blueprint $table) {
            $table->dropColumn([
                    'qty'
                ]);
        });
    }
}
