<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Control\Entities\Comment;

class CommentController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->except(['index']);
    }

    function index($model ,$modelId)
    {
        $comments = Comment::where('commentable_type','=',$model)->where('commentable_id','=',$modelId)->get();

        return response()->json(['comments' => view('site.page.partials.comments',['comments' => $comments ])->render() ,'comments_count' => $comments->count() ]);
    }

    function store(Request $request ,$model ,$modelId)
    {
        $this->validate($request ,[
            'message' => 'required',
        ]);

        $comment = Comment::create(['text' => $request->input('message'),'date' => Carbon::now(), 'user_id' => \Auth::id() ,'commentable_type' => $model ,'commentable_id' => $modelId]);

        return response()->json(['comments' => view('site.page.partials.comments',['comments' => collect([$comment]) ])->render()]);
    }

    function destroy(Request $request ,$id)
    {
        Comment::destroy($id);

        return response()->json(['success' => true]);
    }
}
