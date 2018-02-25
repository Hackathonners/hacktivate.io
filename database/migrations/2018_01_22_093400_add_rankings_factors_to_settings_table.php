<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRankingsFactorsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('factor_followers')->unsigned()->default(8);
            $table->decimal('factor_gists')->unsigned()->default(3);

            // Repositories
            $table->decimal('factor_number_repositories')->unsigned()->default(1);
            $table->decimal('factor_repository_contributions')->unsigned()->default(10);
            $table->decimal('factor_repository_stars')->unsigned()->default(5);
            $table->decimal('factor_repository_watchers')->unsigned()->default(2);
            $table->decimal('factor_repository_forks')->unsigned()->default(2);
            $table->decimal('factor_repository_size')->unsigned()->default(0.5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'factor_followers',
                'factor_gists',
                'factor_number_repositories',
                'factor_repository_contributions',
                'factor_repository_stars',
                'factor_repository_watchers',
                'factor_repository_forks',
                'factor_repository_size',
            ]);
        });
    }
}
