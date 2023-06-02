<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('recomondations', function (Blueprint $table) {
            $table->dropColumn('plans');

            $table->unsignedBigInteger('planes_id');

            $table->foreign('planes_id')->references('id')->on('planes');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recomondations', function (Blueprint $table) {

            $table->dropColumn('planes_id');


        });

    }
};
