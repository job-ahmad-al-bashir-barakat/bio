<?php

namespace Aut\FileUpload\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Image extends \Eloquent
{
    use SoftDeletes;

    const FOLDER_STORAGE_PATH = 'upload/image/{folder}';

    protected $fillable = ['name' ,'hash_name' ,'ext' ,'size' ,'width' ,'height'];

    protected $appends = ['image_url' ,'type'];

    public function getImageUrlAttribute()
    {
        $imagePath = self::FOLDER_STORAGE_PATH;

        return url(Storage::url("$imagePath/$this->hash_name"));
    }

    public function getTypeAttribute()
    {
        return 'image';
    }
}
