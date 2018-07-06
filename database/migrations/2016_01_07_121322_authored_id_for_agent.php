<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuthoredIdForAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('agent_authors'))
	    {
		    Schema::create('agent_authors', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->unsignedInteger('agent_id');
			    $table->unsignedInteger('authored_id');

			    $table->timestamps();
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->foreign('authored_id')->references('id')->on('agents');
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
	    if (Schema::hasTable('agent_authors'))
	    {
		    Schema::table('agent_authors', function(Blueprint $table)
		    {
			    $table->dropForeign('agent_authors_agent_id_foreign');
			    $table->dropForeign('agent_authors_authored_id_foreign');
		    });
	    }

	    Schema::dropIfExists('agent_authors');
    }
}
