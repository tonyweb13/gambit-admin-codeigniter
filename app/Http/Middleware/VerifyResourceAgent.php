<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Resources\Agent as Resource;
use App\Models\Agent;
use Closure;

class VerifyResourceAgent
{
	/**
	 * @var \App\Models\Agent
	 */
	protected $agent;

	/**
	 * @var \App\Http\Controllers\Resources\Agent
	 */
	protected $resource;

	/**
	 * VerifyResourceAgent constructor.
	 * @param \App\Models\Agent $agent
	 * @param \App\Http\Controllers\Resources\Agent $resource
	 */
	public function __construct(Agent $agent, Resource $resource)
	{
		$this->agent = $agent;
		$this->resource = $resource;
	}


	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    # Check if the given agent does exist
	    $resource = $this->resource;
	    $response = $this->resource->show($request->segment(2));

	    if ($response->getStatusCode() == $resource::HTTP_STATUS_OK) {
		    $request->agent = $resource->getModel();
		    return $next($request);
	    }
		return $response;
    }
}
