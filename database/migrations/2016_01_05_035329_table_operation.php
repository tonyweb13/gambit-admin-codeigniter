<?php

use App\Models\Agent;
use App\Models\Manager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Models\Base as Model;
class TableOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('agents'))
	    {
		    Schema::create('agents', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('agent_id', 20)->default('');
			    $table->string('agent_key', 100)->nullable();
			    $table->string('agent_code', 10)->nullable();
			    $table->enum('status', [Model::ALLOWED, Model::DENIED])->default(Model::ALLOWED);
			    $table->timestamp('reg_date')->nullable();
			    $table->decimal('amount', 20, 2)->default(0.0);
			    $table->boolean('limit')->default(true);

			    $table->timestamps();
			    $table->unique('agent_id');
			    $table->unique('agent_code');
		    });

		    # Set their starting increment values
		    $sql = "ALTER TABLE agents AUTO_INCREMENT = 10030;";
		    DB::unprepared($sql);
	    }

	    if (!Schema::hasTable('managers'))
	    {
		    Schema::create('managers', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('manager_id', 20)->default('');
			    $table->string('manager_key', 100)->nullable();
			    $table->unsignedInteger('agent_id');
			    $table->unsignedInteger('language_id')->nullable();
			    $table->string('token', 20)->nullable();
			    $table->string('token_time', 10)->nullable();
			    $table->string('phone', 20)->nullable();
			    $table->timestamp('reg_date'); // TODO: Set default value to current timestamp
			    $table->boolean('locked')->default(false);
			    $table->string('memo')->nullable();

			    $table->timestamps();
			    $table->unique('manager_id');
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->foreign('language_id')->references('id')->on('languages');
		    });
	    }

	    if (!Schema::hasTable('agent_operations')) {
		    Schema::create('agent_operations', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('gsp_id');
			    $table->unsignedInteger('agent_id');
			    $table->enum('allowed', [Model::ALLOWED, Model::DENIED])->default(Model::DENIED);
			    $table->timestamps();

			    $table->foreign('gsp_id')->references('id')->on('gsps');
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->unique(['gsp_id', 'agent_id']);
		    });
	    }

	    if (!Schema::hasTable('agent_hierarchies')) {
		    Schema::create('agent_hierarchies', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('agent_id');
			    $table->unsignedInteger('parent_id');

			    $table->timestamps();
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->foreign('parent_id')->references('id')->on('agents');
		    });
	    }

	    if (!Schema::hasTable('agent_configurations')) {
		    Schema::create('agent_configurations', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('agent_id');
			    $table->unsignedInteger('gsp_id');
			    $table->unsignedInteger('rates')->default(0);
			    $table->unsignedInteger('exchange')->default(0);
			    $table->smallInteger('gmt')->default(0);

			    $table->timestamps();
			    $table->foreign('agent_id')->references('id')->on('agents');
			    $table->foreign('gsp_id')->references('id')->on('gsps');
		    });
	    }

	    if (!Schema::hasTable('agent_transactions')) {
		    Schema::create('agent_transactions', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('manager_id');
			    $table->unsignedInteger('from_agent_id');
			    $table->unsignedInteger('to_agent_id');
			    $table->decimal('amount', 10, 2)->nullable();
			    $table->timestamp('balance_date')->nullable();

			    $table->timestamps();
			    $table->foreign('from_agent_id')->references('id')->on('agents');
			    $table->foreign('to_agent_id')->references('id')->on('agents');
			    $table->foreign('manager_id')->references('id')->on('managers');
		    });
	    }

	    if (!Schema::hasTable('manager_hierarchies')) {
		    Schema::create('manager_hierarchies', function (Blueprint $table) {
			    $table->increments('id');
			    $table->unsignedInteger('manager_id');
			    $table->unsignedInteger('parent_id');

			    $table->timestamps();
			    $table->foreign('manager_id')->references('id')->on('managers');
			    $table->foreign('parent_id')->references('id')->on('managers');
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

	    if (Schema::hasTable('manager_hierarchies'))
	    {
		    Schema::table('manager_hierarchies', function(Blueprint $table)
		    {
			    $table->dropForeign('manager_hierarchies_manager_id_foreign');
			    $table->dropForeign('manager_hierarchies_parent_id_foreign');
		    });
	    }

	    if (Schema::hasTable('agent_transactions'))
	    {
		    Schema::table('agent_transactions', function(Blueprint $table)
		    {
			    $table->dropForeign('agent_transactions_from_agent_id_foreign');
			    $table->dropForeign('agent_transactions_to_agent_id_foreign');
			    $table->dropForeign('agent_transactions_manager_id_foreign');
		    });
	    }

	    if (Schema::hasTable('agent_configurations'))
	    {
		    Schema::table('agent_configurations', function(Blueprint $table)
		    {
			    $table->dropForeign('agent_configurations_agent_id_foreign');
			    $table->dropForeign('agent_configurations_gsp_id_foreign');
		    });
	    }

	    if (Schema::hasTable('agent_hierarchies'))
	    {
		    Schema::table('agent_hierarchies', function(Blueprint $table)
		    {
			    $table->dropForeign('agent_hierarchies_agent_id_foreign');
			    $table->dropForeign('agent_hierarchies_parent_id_foreign');
		    });
	    }

        if (Schema::hasTable('agent_operations'))
        {
            Schema::table('agent_operations', function(Blueprint $table)
            {
                $table->dropForeign('agent_operations_agent_id_foreign');
                $table->dropForeign('agent_operations_gsp_id_foreign');
            });
        }

	    if (Schema::hasTable('managers'))
	    {
		    Schema::table('managers', function(Blueprint $table)
		    {
			    $table->dropForeign('managers_agent_id_foreign');
		    });
	    }

	    Schema::dropIfExists('manager_hierarchies');
	    Schema::dropIfExists('agent_transactions');
	    Schema::dropIfExists('agent_configurations');
	    Schema::dropIfExists('agent_hierarchies');
	    Schema::dropIfExists('agent_operations');
	    Schema::dropIfExists('managers');
	    Schema::dropIfExists('agents');

    }
}
