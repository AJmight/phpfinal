<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('position'); // E.g., 'Forward', 'Midfielder', 'Defender', 'Goalkeeper'
            $table->integer('shirt_number'); // Consider composite unique key [team_id, shirt_number]
            $table->string('photo_url')->nullable();
            $table->enum('status', ['active', 'injured', 'suspended', 'inactive'])->default('active');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Consider adding
            // Add constraint for shirt_number uniqueness per team if needed:
            $table->unique(['team_id', 'shirt_number']);
        });
        
        
        
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}