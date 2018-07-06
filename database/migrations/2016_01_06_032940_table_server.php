<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('agent_servers'))
	    {
		    Schema::create('agent_servers', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->unsignedInteger('agent_id');
			    $table->string('name', 20)->default('');
			    $table->string('ip')->nullable();
			    $table->string('memo')->nullable();
			    $table->timestamp('reg_date')->nullable();


			    $table->timestamps();
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->unique('name');
		    });

		    # Set their starting increment values
		    $sql = "ALTER TABLE agent_servers AUTO_INCREMENT = 160;";
		    DB::unprepared($sql);
	    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    if (Schema::hasTable('agent_servers'))
	    {
		    Schema::table('agent_servers', function(Blueprint $table)
		    {
			    $table->dropForeign('agent_servers_agent_id_foreign');
		    });
	    }

        Schema::dropIfExists('agent_servers');
    }
}
