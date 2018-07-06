<?php

namespace App\Listeners;

use App\Events\AgentWasCreated;
use App\Models\ActivityLog as Logger;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivityLog
{
	/**
	 * Create the event listener.
	 *
	 * @param Logger $logger
	 */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param  AgentWasCreated  $event
     * @return void
     */
    public function handle(AgentWasCreated $event)
    {
	    $this->logger->fill([
		    'action_code' => $event->getActivityCode(),
		    'short_description' => $event->getActivityLongDescription(),
		    'long_description' => $event->getActivityShortDescription(),
	    ]);
	    $this->logger->sessionLog()->associate($event->session);
	    $event->agent->activities()->save($this->logger);
    }
}
