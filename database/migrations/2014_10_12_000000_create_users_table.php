<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('github_handle');
            $table->integer('phone_number')->unsigned()->nullable();
            $table->string('genre')->nullable();
            $table->string('shirt_size');
            $table->date('birthdate');
            $table->string('dietary_restrictions')->nullable();
            $table->string('school');
            $table->string('major');
            $table->integer('role_id')->unsigned();
            $table->string('study_level')->nullable();
            $table->string('special_needs')->nullable();
            $table->text('bio')->nullable();
            $table->integer('team_id')->nullable()->unsigned();
            $table->integer('owner_team_id')->unsigned()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('team_id')->references('id')->on('team');
            $table->foreign('owner_team_id')->references('owner_id')->on('team');

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
