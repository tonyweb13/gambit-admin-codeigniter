<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Currencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('currencies'))
	    {
		    Schema::create('currencies', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('code', 5);
			    $table->string('country');
			    $table->decimal('exchange_rate_against_usd', 12, 5)->nullable();
			    $table->boolean('is_iso_standard')->default(true);
			    $table->timestamps();
                $table->unique('code');
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
        Schema::dropIfExists('currencies');
    }
}
