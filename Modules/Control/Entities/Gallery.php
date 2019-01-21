<?php

namespace Modules\Control\Entities;

use Aut\FileUpload\Entities\Image;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title' ,'short_description', 'user_id' ,'image_id'];

    protected $with = ['image'];

    function image()
    {
        return $this->belongsTo(Image::class);
    }
}
