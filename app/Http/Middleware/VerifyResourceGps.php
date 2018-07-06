<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Gsp;
use App\Http\Controllers\Resources\Gsp as Resource;

class VerifyResourceGps
{

	/**
	 * VerifyResourceAgent constructor.
	 * @param \App\Models\Gsp $gsp
	 * @param \App\Http\Controllers\Resources\Gsp $resource
	 */
	public function __construct(Gsp $gsp, Resource $resource)
	{
		$this->gsp = $gsp;
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
		    $request->gsp = $resource->getModel();
		    return $next($request);
	    }

        return $response;
    }
}
