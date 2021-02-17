<?php

namespace Oka6\Admin\Http\Middleware;


use Closure;

class Cors
{
	/**
	 * @param $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		return $next($request)
			->header('Access-Control-Allow-Origin', "*")
			->header('Access-Control-Allow-Methods', "PUT, POST, DELETE, GET, OPTIONS")
			->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");
	}
}
