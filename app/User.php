<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Aut\FileUpload\Entities\Image;

class User extends Authenticatable
{
    use Notifiable;

	const SUPER_ADMIN_ID = 5;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name', 'email', 'password','is_active','is_admin','image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	protected $with = ['image'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    function setPasswordAttribute($password)
    {
        if(empty($password))
            $password = $this->getOriginal('password');
        else
            if($password != $this->getOriginal('password'))
                $password = bcrypt($password);

        $this->attributes['password'] = $password;
    }

    function image()
    {
        return $this->belongsTo(Image::class);
    }
}
