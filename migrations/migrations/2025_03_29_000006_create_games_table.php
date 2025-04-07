<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('start_time');
            $table->string('venue')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'postponed', 'cancelled'])->default('scheduled');
            $table->integer('result_1')->nullable(); // Team 1 score
            $table->integer('result_2')->nullable(); // Team 2 score
            $table->unsignedBigInteger('team_1_id');
            $table->foreign('team_1_id')->references('id')->on('teams');
            $table->unsignedBigInteger('team_2_id');
            $table->foreign('team_2_id')->references('id')->on('teams');
            $table->unsignedBigInteger('referee_id')->nullable();
            $table->foreign('referee_id')->references('id')->on('referees'); // Points to recommended table
            $table->integer('attendance')->nullable();
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
