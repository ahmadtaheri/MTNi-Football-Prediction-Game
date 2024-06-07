<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->String('teamA');
            $table->String('teamB');
//            $table->Integer('matchYear');
//            $table->Integer('matchMonth');
//            $table->Integer('matchDay');
//            $table->Integer('matchHour');
//            $table->Integer('matchMinute');
//            $table->Integer('matchSecond');
            $table->dateTime('matchTime');
            $table->unsignedBigInteger('teamA_score')->default(Null)->nullable();
            $table->unsignedBigInteger('teamB_score')->default(Null)->nullable();
            $table->unsignedBigInteger('winner')->default(Null)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
