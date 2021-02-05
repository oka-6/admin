<?php

namespace Oka6\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Oka6\Admin\Notifications\ResetPasswordNotification;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, Notifiable;
	
	const TABLE = 'users';
	const PROFILE_ID_ROOT = 5047785;
	public $rules = [
		'cell_phone' => 'required',
		'resource_default_id' => 'required',
		'name' => 'required',
		'email' => 'required',
		'password' => 'required|min:6|confirmed',
		'password_confirmation' => 'required|min:6|',
		'profile_id' => 'required',
		'client_id' => 'required',
	
	];
	protected $table = 'users';
	protected $connection = 'oka6_admin';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'email',
		'password',
		'lastname',
		'cell_phone',
		'active',
		'profile_id',
		'resource_default_id',
		'verified_email',
		'confirmation_token',
		'picture',
		'type',
		'client_id'
	];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public static function hasUserCreated()
	{
		return self::count();
	}
	
	public function resourceDefault()
	{
		return Resource::where('id', $this->resource_default_id)->first();
	}
	
	public function getById($id)
	{
		return self::where('id', (int)$id)->first();
	}
	
	
	/**
	 * Send the password reset notification.
	 * @note: This override Authenticatable methodology
	 *
	 * @param string $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification());
	}
	
	public static function generateToken()
	{
		return md5(microtime(true));
	}
	
	public function hasConfirmed()
	{
		return $this->verified_email == 1 ? true : false;
	}
	
	public static function confirm($user, $token)
	{
		if ($user->verified_email == 1) return false;
		
		if ($token === $user->confirmation_token) {
			// User has confirmed his e-mail address.
			$user->confirmation_token = null;
			$user->verified_email = 1;
			$user->save();
			
			return true;
		}
		return false;
	}
	
	public static function updateClientID($user, $newClientID)
	{
		if (!$user->client_id) {
			$user->client_id = $newClientID;
			$user->save();
			return true;
		}
		return false;
	}
}
