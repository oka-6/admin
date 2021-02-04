<?php

namespace Oka6\Admin\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Profile extends Model {
	
	const TABLE = 'profile';
	protected $fillable = ['id', 'name', 'desc', 'resources_allow', 'type'];
	protected $connection = 'oka6_admin';
	protected $table = 'profile';
	
	const PROFILE_NEW_USER_ID = 31;
	const RESOURCE_DEFAULT_ID = 44;
	
	public static function getById($id) {
		return self::where('id', (int)$id)->first();
	}
	
	public static function getProfilesByTypes($type) {
		if (is_array($type)) {
			if (($key = array_search('Admin', $type)) !== false) {
				unset($type['admin']);
			}
			
			return self::whereIn('type', $type)->get();
		}
		return self::where('type', $type)->get();
	}
	
	public static function getProfilesByIdAndTypes($profileId, $type) {
		if (is_array($type)) {
			if (($key = array_search('Admin', $type)) !== false) {
				unset($type['admin']);
			}
			
			return self::whereIn('type', $type)->where('id', (int)$profileId)->first();
		}
		return self::where('type', $type)->where('id', (int)$profileId)->first();
	}
	
}
