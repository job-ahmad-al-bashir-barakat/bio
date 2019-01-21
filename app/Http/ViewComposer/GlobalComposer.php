<?php
namespace App\Http\ViewComposer;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Admin\Entities\Lang;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GlobalComposer
{
    public function compose(View $view)
    {
        $view->with([
            'dir'     => LaravelLocalization::getCurrentLocaleDirection(),
            'lang'    => LaravelLocalization::getCurrentLocale(),
            'pos'     => LaravelLocalization::getCurrentLocaleDirection() == 'ltr' ? 'left' : 'right',
            'revPos'  => LaravelLocalization::getCurrentLocaleDirection() == 'ltr' ? 'right' : 'left',
            'user'    => \Auth::user(),
            'is_user' => \Auth::check(),
        ]);
    }
}