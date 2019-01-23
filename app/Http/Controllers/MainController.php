<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Aut\FileUpload\Entities\Image;
use Illuminate\Http\Request;
use Modules\Control\Entities\Category;
use Modules\Control\Entities\Faq;
use Modules\Control\Entities\FaqType;
use Modules\Control\Entities\News;
use Storage;

class MainController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->only(['profile', 'changeProfile']);
    }

    function home()
    {
        $categories = Category::all();

        return view('site.home', ['categories' => $categories]);
    }

    function news ()
    {
        $news = News::paginate(5);

        return view('site.page.news' ,['news' => $news]);
    }

//    function about ()
//    {
//        return view('site.page.about');
//    }

    function faq ()
    {
        $faqTypesNames = [];

        $faqs = Faq::all()->groupBy('faq_type_id');
        $faqs->filter(function($value, $index) use (&$faqTypesNames) {
            $faqTypesNames[] = [
                'index' => $index ,
                'name' => FaqType::where('id','=',$index)->get([lang('name')])->first()->{lang('name')}
            ];
        });

        return view('site.page.faq', ['faqs' => $faqs, 'faqTypesNames' => $faqTypesNames]);
    }

    function profile ()
    {
        $user = \Auth::user();

        return view('site.page.profile',['user' => $user]);
    }

    private function UploadImage(Request $request ,$image)
    {
        $file = $request->file($image);

        Storage::makeDirectory("public\\upload\\image\\users");

        $path       = storage_path("app\\public\\upload\\image\\users");
        $hashName   = strtolower(str_random(12))."_". $file->getClientOriginalName();

        $imgRezise = \Image::make($file->getRealPath());
        $imgRezise->fit(64, 64)->save("$path/$hashName");

        $extraParams =  [
            'name'      => $file->getClientOriginalName(),
            'hash_name' => $hashName,
            'ext'       => $file->getClientOriginalExtension(),
            'width'     => '64',
            'height'    => '64',
            'size'      => $file->getClientSize(),
        ];

        $image = Image::create($extraParams);

        return $image;
    }

    function changeProfile (Request $request)
    {

        if(request()->file('personal_image',false)) {
            $image = $this->UploadImage($request,'personal_image');
            $image = ['image_id' => $image->id];
        } else {
            $image = [];
        }

        $checkPassword = [];

        if($request->input('passowrd' ,''))
            $checkPassword = [
                'password' => 'required|string|min:6|confirmed'
            ];

        $this->validate($request,array_merge([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.\Auth::id().',id'
        ],$checkPassword));

        \Auth::user()->update(array_merge($request->except('_token'), $image));

        return \Redirect::back();
    }

//    function gallery ()
//    {
//        return view('site.page.gallery');
//    }
}
