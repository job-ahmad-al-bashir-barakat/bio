<?php

namespace Modules\Control\Factories;

use Aut\DataTable\Factories\GlobalFactory;
use Modules\Control\Entities\Comment;

class CommentFactory extends GlobalFactory
{

    /**
     *  get datatable query
     */
    public function getDatatable($Comment, $request)
    {
        $query = Comment::where('commentable_id','=',request()->input('id'))
                        ->where('commentable_type','=',request()->input('type'))->get();

        return $this->table
            ->queryConfig('comment')
            ->queryDatatable($query)
            ->queryDeleteButton('id')
            ->queryRender();
    }

    /**
     *  build datatable modal and table
     */
    public function buildDatatable($Comment, $request)
    {
        return $this->table
            ->config('comment', trans('control::app.comment'),['disableDialog' => true])
            ->addViewField(trans('control::app.comment'), 'text', 'text', 'text')
            ->addViewField(trans('control::app.date'), 'date', 'date', 'date')
            ->addActionButton($this->delete, 'delete', 'delete')
            ->render();
    }

    /**
     *  inline validate dialog form
     */
    public function validateDatatable()
    {
        return [];
    }
}
