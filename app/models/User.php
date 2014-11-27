<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * An administrative user.
 * 
 * @property int $id The internal ID
 * @property string $email the email address, used for login
 * @property string $password the password hash
 * @property string $access_token the Facebook access token
 * @property int $remember_token the token for RememberMe login
 * @property FbPage[] $fbPages the Facebook pages, associated to the user
 * 
 * @author Max Vogler
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $hidden = ['password', 'remember_token', 'access_token'];

    protected $fillable = ['email', 'password', 'access_token'];

	/**
     * @return Builder QueryBuilder for the associated Facebook pages
     */
	public function fbPages() {
		return $this->hasMany('FbPage');
	}

}
