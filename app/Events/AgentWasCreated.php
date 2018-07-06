<?php

namespace App\Events;

use App\Models\Agent;
use App\Models\SessionLog;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AgentWasCreated extends EventActivity
{
    use SerializesModels;

	public $agent;

	public $session;

	/**
	 * Create a new event instance.
	 *
	 * @param Agent $agent
	 * @param SessionLog $session
	 */
    public function __construct(Agent $agent, SessionLog $session)
    {
        $this->agent = $agent;
	    $this->session = $session;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
	        'activity.' . $this->getActivityCode()
        ];
    }

	/**
	 * getActivityCode
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	public function getActivityCode()
	{
		return 'AC';
	}

	/**
	 * getActivityShortDescription
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	public function getActivityShortDescription()
	{
		return 'Agent Creation';
	}

	/**
	 * getActivityLongDescription
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	public function getActivityLongDescription()
	{
		return sprintf('An agent with an id of %s is successfully registered.',
			$this->agent->agent_id);
	}
}
