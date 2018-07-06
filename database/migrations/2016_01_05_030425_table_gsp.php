<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableGsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('gsps')) {
		    Schema::create('gsps', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('name', 100);
			    $table->smallInteger('gmt')->default(0);

			    $table->timestamps();
		    });

		    # Set their starting increment values
		    $sql = "ALTER TABLE gsps AUTO_INCREMENT = 1030;";
		    DB::unprepared($sql);
	    }

	    if (!Schema::hasTable('gsp_urls')) {
		    Schema::create('gsp_urls', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('gsp_id');
			    $table->string('url')->default('');
			    $table->string('name');

			    $table->foreign('gsp_id')->references('id')->on('gsps');
			    $table->timestamps();
		    });
	    }

	    if (!Schema::hasTable('gsp_currencies')) {
		    Schema::create('gsp_currencies', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('gsp_id');
			    $table->unsignedInteger('currency_id');
			    $table->string('name', 20)->default('');
			    $table->string('merch_id', 50)->default('');
			    $table->string('merch_pwd')->default('');
			    $table->string('game_url')->default('');
			    $table->string('api_url')->default('');

			    $table->foreign('gsp_id')->references('id')->on('gsps');
			    $table->foreign('currency_id')->references('id')->on('currencies');
			    $table->timestamps();
			    $table->unique(['currency_id', 'gsp_id']);
		    });
	    }

	    if (!Schema::hasTable('gsp_additional_info')) {
		    Schema::create('gsp_additional_info', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('gsp_id');
//			    $table->unsignedInteger('gsp_currency_id');
			    $table->string('name');
			    $table->string('value')->nullable();

			    $table->foreign('gsp_id')->references('id')->on('gsps');
//			    $table->foreign('gsp_currency_id')->references('id')->on('gsp_currencies');
			    $table->timestamps();
			    $table->unique(['name', 'gsp_id']);
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
	    if (Schema::hasTable('gsp_additional_info'))
	    {
		    Schema::table('gsp_additional_info', function(Blueprint $table)
		    {
			    $table->dropForeign('gsp_additional_info_gsp_id_foreign');
//			    $table->dropForeign('gsp_additional_info_gsp_currency_id_foreign');
		    });
	    }

	    if (Schema::hasTable('gsp_currencies'))
	    {
		    Schema::table('gsp_currencies', function(Blueprint $table)
		    {
			    $table->dropForeign('gsp_currencies_gsp_id_foreign');
			    $table->dropForeign('gsp_currencies_currency_id_foreign');
		    });
	    }

	    if (Schema::hasTable('gsp_urls'))
	    {
		    Schema::table('gsp_urls', function(Blueprint $table)
		    {
			    $table->dropForeign('gsp_urls_gsp_id_foreign');
		    });
	    }

	    Schema::dropIfExists('gsp_additional_info');
	    Schema::dropIfExists('gsp_currencies');
	    Schema::dropIfExists('gsp_urls');
	    Schema::dropIfExists('gsps');
    }
}
