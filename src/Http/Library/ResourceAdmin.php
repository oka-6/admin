<?php

namespace Oka6\Admin\Http\Library;

use Illuminate\Support\Facades\Auth;
use Oka6\Admin\Models\Resource;

class ResourceAdmin {
	public static function verifyUser($controllerAction) {
		
		$controller = $controllerAction;
		$findController = Resource::where('controller_method', '=', $controller)->first();
		if ($findController == null) {
			return false;
		}
		$userResources = Resource::getResourcesByProfiles(Auth::user()->profile_id, $controller);
		if (abort_if(Auth::user()->active == 0, 404, ' Desculpe, não é possível acessar o sistema! Entre em contato com o administrador '))
			
			if (!$userResources) {
				$userResources = [];
			} else {
				$userResources = $userResources->toArray();
			}
		
		return $userResources;
	}
	
	public static function hasResourceByRouteName($routeName, $params = []) {
		$findResource = Resource::where('route_name', '=', $routeName)->first();
		if ($findResource == null) {
			return false;
		}
		$userResources = Resource::getResourcesByRouteName(Auth::user()->profile_id, $routeName);
		if (count($userResources)) {
			return route($routeName, $params);
		}
		return false;
	}
	
	
}
