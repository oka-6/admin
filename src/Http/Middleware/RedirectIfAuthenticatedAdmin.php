<?php

namespace Oka6\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Oka6\Admin\Models\Resource;

class RedirectIfAuthenticatedAdmin {
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 * @param string|null $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		$prefix_url = Config::get('admin.prefix_url');
		
		if (Auth::guard($guard)->check()) {
			$redirect = Resource::where('id', (int)Auth::User()->resource_default_id)->first();
			if ($redirect && isset($redirect->route_name)) {
				return redirect(route($redirect->route_name));
			}
			return redirect("/$prefix_url/page-not-found");
		}
		
		return $next($request);
	}
}
