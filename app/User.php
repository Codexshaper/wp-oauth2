<?php

namespace Codexshaper_Oauth_Server\App;

use Illuminate\Database\Eloquent\Model;

/**
 * User model.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class User extends Model {

	protected $primaryKey = 'ID';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'name',
		'email',
		'password',
	);

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = array(
		'password',
		'remember_token',
	);

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = array(
		'email_verified_at' => 'datetime',
	);
}
