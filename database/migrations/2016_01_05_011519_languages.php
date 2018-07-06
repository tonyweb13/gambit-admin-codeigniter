<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Languages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('languages'))
	    {
		    Schema::create('languages', function(Blueprint $table)
		    {
				$table->increments('id');
			    $table->string('code1', 2);
			    $table->string('code2', 3);
			    $table->string('name');

			    $table->unique(['code1', 'code2', 'name']);
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
        Schema::dropIfExists('languages');
    }
}
