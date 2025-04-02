<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGamesTable extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->unsignedBigInteger('team_1_id')->nullable();
            $table->foreign('team_1_id', 'team_1_fk_10515077')->references('id')->on('teams');
            $table->unsignedBigInteger('team_2_id')->nullable();
            $table->foreign('team_2_id', 'team_2_fk_10515078')->references('id')->on('teams');
        });
}


    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign('team_1_fk_10515077');
            $table->dropForeign('team_2_fk_10515078');
            $table->dropColumn('team_1_id');
            $table->dropColumn('team_2_id');
        });
    }
}
