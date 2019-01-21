<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Control\Entities\Company;

class RateController extends Controller
{
    protected $models = [
        'company' => Company::class,
    ];

    function __construct()
    {
        $this->middleware(['auth']);
    }

    function store($model ,$modelId)
    {
        $model = $this->models[$model];

        $model = $model::where('id','=',$modelId)->first();

        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = \request('rate');
        $rating->user_id = \Auth::id();

        if($model->userAverageRating)
            $model->ratings()->delete(\Auth::id());

        $model->ratings()->save($rating);
    }
}
