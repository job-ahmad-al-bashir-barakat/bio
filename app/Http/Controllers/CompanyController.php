<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Control\Entities\Company;
use Modules\Control\Entities\Job;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->only(['owner']);
    }

    public function index(Request $request ,Company $companies)
    {
        // search keyword
        $keyword = replaceSearch($request->get('keyword',''));
        if($request->get('keyword',''))
            $companies = $companies->where('name','like',$keyword)
                                   ->orWhere('headline','like',$keyword)
                                   ->orWhere('short_description','like',$keyword);

        // search location
        if($request->get('location',''))
            $companies = $companies->whereHas('contact',function ($query) use($request) {
                $query->where('geolocation_search','like',replaceSearch($request->get('location','')));
            });

        $companies = $companies
            ->where('user_id','<>',\Auth::id())
            ->paginate(5);

        return view('site.company.companies',['companies' => $companies]);
    }

    public function owner()
    {
        $companies = Company::where('user_id','=',\Auth::id())
            ->paginate(5);

        return view('site.company.my_companies',['companies' => $companies]);
    }

    public function show($id)
    {
        $company = Company::where('id','=',$id)->first();

        if(request()->ajax())
        {
            $jobs = Job::with(['company.contact'])
                ->where('is_filled','=',false)
                ->where('company_id','=',$id)
                ->skip(request('prePage'))->take(request('page'))->get();

            return response()->json(['content' => view('site.position._jobs',['jobs' => $jobs ])->render() ]);
        }

        $jobs = Job::with(['company.contact'])
            ->where('is_filled','=',false)
            ->where('company_id','=',$id)
            ->take(3)->get();

        return view('site.company.company-detail',['company' => $company,'jobs' => $jobs]);
    }
}
