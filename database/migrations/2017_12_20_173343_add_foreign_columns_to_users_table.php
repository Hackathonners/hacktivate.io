<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
<<<<<<< 425191c7f11a92e52a1aff35c4a1d5137df11f2b
            $table->integer('team_id')->nullable()->unsigned();
            $table->integer('owner_team_id')->nullable()->unsigned();
            $table->integer('role_id')->nullable()->unsigned();

            $table->foreign('team_id')->references('id')->on('team');
            $table->foreign('owner_team_id')->references('owner_id')->on('team');
            $table->foreign('role_id')->references('id')->on('role');
=======
            $table->integer('team_id')->unsigned()->nullable();
            $table->integer('role_id')->unsigned();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('role_id')->references('id')->on('roles');
>>>>>>> Resolve discussions
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['team_id', 'owner_team_id', 'role_id']);
        });
    }
}
