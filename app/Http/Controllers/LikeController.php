<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Control\Entities\Like;

class LikeController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }

    function store(Request $request ,$model ,$modelId)
    {
        $exists = Like::where('user_id','=',\Auth::id())
            ->where('likeable_type','=',$model)
            ->where('likeable_id','=',$modelId);

        if($exists->count())
        {
            Like::destroy($exists->first()->id);

            return response()->json(['success' => true ,'new' => false]);
        }
        else
        {
            Like::create(['user_id' => \Auth::id() ,'likeable_type' => $model ,'likeable_id' => $modelId]);

            return response()->json(['success' => true ,'new' => true]);
        }
    }
}
