<?php

namespace Modules\Control\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends \Eloquent
{
    use SoftDeletes;

    protected $with = ['faq_type'];

    protected $fillable = ['title_en', 'title_ar', 'content_en', 'content_ar', 'faq_type_id'];

    function faq_type() {

        return $this->belongsTo(FaqType::class);
    }
}
