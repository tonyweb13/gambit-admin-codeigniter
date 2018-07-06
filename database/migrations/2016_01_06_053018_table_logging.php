<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableLogging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (!Schema::hasTable('session_logs'))
	    {
		    Schema::create('session_logs', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('login_url');
			    $table->string('visit_ip');
			    $table->unsignedInteger('country_id');
			    $table->string('isp_provider');
			    $table->string('services');
			    $table->string('session_id');
			    $table->timestamp('logout_at');

			    $table->morphs('responsible');
			    $table->timestamps();
			    $table->foreign('country_id')->references('id')->on('countries');
		    });
	    }

	    if (!Schema::hasTable('activity_logs'))
	    {
		    Schema::create('activity_logs', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->unsignedInteger('session_log_id');
			    $table->string('action_code');
			    $table->string('short_description');
			    $table->text('long_description');
			    $table->timestamp('executed_at');

			    $table->morphs('responsible');
			    $table->timestamps();
			    $table->foreign('session_log_id')->references('id')->on('session_logs');
		    });
	    }

	    if (!Schema::hasTable('gsp_daily_reckons'))
	    {
		    Schema::create('gsp_daily_reckons', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->unsignedInteger('agent_id');
			    $table->unsignedInteger('gsp_id');
			    $table->unsignedInteger('bet_count');
			    $table->decimal('win_loss', 30, 2);
			    $table->decimal('net_loss', 30, 2);
			    $table->decimal('jcon', 30, 2);
			    $table->decimal('jwin', 30, 2);
			    $table->unsignedInteger('running')->default(0);
			    $table->timestamp('from_date');
			    $table->timestamp('to_date');
			    $table->unsignedSmallInteger('to_year')->default(0);
			    $table->unsignedSmallInteger('week_number');

			    $table->timestamps();
			    $table->foreign('agent_id')->references('id')->on('agents');
				$table->foreign('gsp_id')->references('id')->on('gsps');
		    });
	    }

	    if (!Schema::hasTable('sms_usage_histories'))
	    {
		    Schema::create('sms_usage_histories', function(Blueprint $table)
		    {
			    $table->increments('id');
			    $table->string('to');
			    $table->string('network_code', 200);
			    $table->string('message_id', 100);
			    $table->string('msisdn', 50);
			    $table->string('status', 50);
			    $table->string('err_code', 50);
			    $table->decimal('price', 8, 2);
			    $table->string('scts', 50);
				$table->timestamp('message_timestamp');
			    $table->string('client_ref');

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
	    if (Schema::hasTable('session_logs'))
	    {
		    Schema::table('session_logs', function(Blueprint $table)
		    {
			    $table->dropForeign('session_logs_country_id_foreign');
		    });
	    }

	    if (Schema::hasTable('activity_logs'))
	    {
		    Schema::table('activity_logs', function(Blueprint $table)
		    {
			    $table->dropForeign('activity_logs_session_log_id_foreign');
		    });
	    }

	    if (Schema::hasTable('gsp_daily_reckons'))
	    {
		    Schema::table('gsp_daily_reckons', function(Blueprint $table)
		    {
			    $table->dropForeign('gsp_daily_reckons_agent_id_foreign');
			    $table->dropForeign('gsp_daily_reckons_gsp_id_foreign');
		    });
	    }

		Schema::dropIfExists('gsp_daily_reckons');
		Schema::dropIfExists('sms_usage_histories');
	    Schema::dropIfExists('session_logs');
	    Schema::dropIfExists('activity_logs');
    }
}
