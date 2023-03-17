<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('club_id');
            $table->integer('points');
            $table->integer('wins');
            $table->integer('draws');
            $table->integer('losses');
            $table->integer('goals_for');
            $table->integer('goals_against');
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
