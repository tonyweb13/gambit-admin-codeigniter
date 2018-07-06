<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Countries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('countries'))
	    {
		    Schema::create('countries', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('alpha_code_2', 2);
			    $table->string('alpha_code_3', 3);
			    $table->string('numeric_code', 3);
			    $table->string('name');
			    $table->unique(['alpha_code_2', 'alpha_code_3']);
			    $table->unique('name');
			    $table->timestamps();
		    });
	    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('countries');
    }
}
