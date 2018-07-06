<?php

use Illuminate\Database\Migrations\Migration;

class InitLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    $languageSeeder = new LanguageInitialData;
	    $languageSeeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
