<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPlayersTable extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_10515085')->references('id')->on('teams');
        });
}

public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropForeign('team_fk_10515085');
            $table->dropColumn('team_id');
        });
    }
}