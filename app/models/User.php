<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashNotifier;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    protected $fillable = array('username', 'password');

    public static $rules = [
        'username'=>'required',
        'password'=>'required'
    ];

    public function roles()
    {
        return $this->belongsToMany('Role')->withTimestamps();
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if ($role->name == $name)
                return true;
            else return false;
        }
    }



    public function assignRole($role) {
        return $this->roles()->attach($role);
    }

    public function removeRole($role) {
        return $this->roles()->detach($role);
    }
}



