<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Contact extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = ['website' ,'email' ,'phone_number' ,'location','geolocation_title','geolocation_search'];

    protected $casts = [
        'geolocation_title' => 'array'
    ];

    protected $with = ['socialNetwork'];

    protected $appends = ['social'];

    protected static function boot() {

        parent::boot();

        //before delete() method call this
        static::deleting(function($contact) {

            $contact->socialNetwork()->sync([]);
        });
    }

    function socialNetwork()
    {
        return $this->belongsToMany(SocialNetwork::class)->withPivot(['value']);
    }

    function getSocialAttribute()
    {
        return $this->socialNetwork->keyBy('code');
    }
}
