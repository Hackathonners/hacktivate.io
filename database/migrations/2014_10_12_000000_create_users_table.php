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
            $table->string('github');
            $table->string('phone_number')->unsigned()->nullable();
            $table->enum('gender', ['F', 'M', 'Other']);
            $table->date('birthdate');
            $table->string('dietary_restrictions')->nullable();
            $table->string('school');
            $table->string('major');
            $table->string('study_level')->nullable();
            $table->text('special_needs')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
