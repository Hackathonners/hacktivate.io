<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('team_id')->nullable()->unsigned();
            $table->integer('owner_team_id')->nullable()->unsigned();
            $table->integer('role_id')->nullable()->unsigned();

            $table->foreign('team_id')->references('id')->on('team');
            $table->foreign('owner_team_id')->references('owner_id')->on('team');
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
