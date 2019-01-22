<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Control\Entities\ApplyStatus;
use Modules\Control\Entities\Category;
use Modules\Control\Entities\Contract;
use Modules\Control\Entities\Degree;
use Modules\Control\Entities\HourlyRate;
use Modules\Control\Entities\Job;
use Modules\Control\Entities\JobApply;
use Modules\Control\Entities\Resume;

class JobController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->only(['apply', 'send', 'owner', 'filled' ,'suggestion']);
    }

    public function index(Request $request ,Job $job)
    {
        // load more owner jobs
        if(request()->ajax())
        {
            $jobs = Job::with(['company.contact'])->whereHas('company',function ($query) {
                $query->where('user_id','=',\Auth::id());
            })->skip(request('prePage'))->take(request('page'))->get();

            return response()->json(['content' => view('site.resume._resume_apply_jobs',['jobs' => $jobs ])->render() ]);
        }

        $jobs = $job::with(['company.contact']);

        // search location
        if($request->get('location',''))
        {
            $jobs = $jobs->whereHas('company.contact', function ($query) use($request) {
                $query->where('geolocation_search','like',replaceSearch($request->get('location','')));
            });
        }

        // search keyword
        $keyword = replaceSearch($request->get('keyword',''));
        if($request->get('keyword',''))
        {
            $jobs = $jobs->where('name','like',$keyword)
                ->orWhere('short_description','like',$keyword)
                ->orWhereHas('company',function ($query) use($request, $keyword){
                    $query->where('name','like',$keyword);
                });
        }

        // search rate
        $requestRate = $request->get('rate',[]);
        if(is_array($requestRate) && $requestRate)
        {
            foreach ($requestRate as $index => $rate)
            {
                $rate = explode(',',$rate);
                if(!$rate[1]) $rate[1] = "1000000";

                if($index == 0)
                    $jobs = $jobs->where(function ($query) use ($rate) {
                        $query->whereBetween('salary',$rate);
                    });
                else
                    $jobs = $jobs->orWhere(function ($query) use ($rate) {
                        $query->whereBetween('salary',$rate);
                    });
            }
        }

        // search degree
        $requestDegrees = $request->get('degree',[]);
        if(is_array($requestDegrees) && $requestDegrees)
        {
            $jobs = $jobs->whereHas('degree',function ($query) use($request, $requestDegrees){
                $query->whereIn('degree_id', $requestDegrees);
            });
        }

        // search contract
        $requestContracts = $request->get('contract',[]);
        if(is_array($requestContracts) && $requestContracts)
        {
            $jobs = $jobs->whereHas('contract',function ($query) use($request, $requestContracts){
                $query->whereIn('id', $requestContracts);
            });
        }

        // search category
        $requestCategories = $request->get('category',[]);
        if(is_array($requestCategories) && $requestCategories)
        {
            $jobs = $jobs->whereHas('category',function ($query) use($request, $requestCategories){
                $query->whereIn('id', $requestCategories);
            });
        }

        $jobs = $jobs->where('is_filled','=',false)
                     ->where('job_status','=','w')
                     ->whereHas('company',function ($query) {
                         $query->where('user_id','<>',\Auth::id());
                     })
                     ->orderBy('last_update','desc')
                     ->paginate(5);

        $categories = Category::all();
        $hourlyRate = HourlyRate::all();
        $contracts  = Contract::all();
        $degrees    = Degree::all();

        return view('site.position.jobs',['jobs' => $jobs, 'categories' => $categories, 'hourlyRate' => $hourlyRate, 'contracts' => $contracts, 'degrees' => $degrees]);
    }

    public function owner()
    {
        $jobs = Job::whereHas('company',function ($query) {
                $query->where('user_id','=',\Auth::id());
            })
            ->orderBy('last_update','desc')
            ->paginate(5);

        return view('site.position.my_jobs',['jobs' => $jobs]);
    }

    public function category($id)
    {
        $jobs = Job::with(['company.contact'])
            ->whereHas('company',function ($query) {
                $query->where('user_id','<>',\Auth::id());
            })
            ->where('category_id','=',$id)
            ->where('is_filled','=',false)
            ->orderBy('last_update','desc')
            ->paginate(5);

        $categories = Category::all();
        $hourlyRate = HourlyRate::all();
        $contracts  = Contract::all();
        $degrees    = Degree::all();

        return view('site.position.jobs',['jobs' => $jobs ,'categories' => $categories ,'hourlyRate' => $hourlyRate ,'contracts' => $contracts ,'degrees' => $degrees ]);
    }

    public function show($id)
    {
        $job = Job::with(['company.contact.socialNetwork','HasJobApply'])
            ->where('id', '=', $id)
            ->first();

        return view('site.position.job-detail', ['job' => $job]);
    }

    public function apply($id)
    {
        $job = Job::with(['company.contact'])->where('id', '=', $id)
            ->where('is_filled','=',false)
            ->first();

        // dont't allow owner to apply its resume
        if(\Auth::id() == $job->company->user_id)
            return;

        $resumes = Resume::where('user_id','=',\Auth::id())
            ->take(5)
            ->get();

        return view('site.position.job-apply', ['job' => $job, 'resumes' => $resumes ]);
    }

    public function send(Request $request, $id)
    {
        $this->validate($request,[
            'subject' => 'required',
            'message' => 'required',
            'resume'  => 'required',
        ]);

        $ApplyStatusNew = ApplyStatus::where('code','=','new')->first();

        JobApply::create([
            'subject'   => $request->get('subject'),
            'message'   => $request->get('message'),
            'resume_id' => $request->get('resume'),
            'apply_status_id' => $ApplyStatusNew->id,
            'job_id'    => $id,
            'user_id'   => \Auth::id(),
        ]);

        return \Redirect::intended(\RouteUrls::site_jobs());
    }

    public function filled()
    {

        $job = Job::where('id','=',request('id'))->first();

        $is_filled = $job->is_filled;

        $job->update(['is_filled' => !$is_filled]);

        // response
        if($job->is_filled)
            $btn_title = trans('app.mark_empty');
        else
            $btn_title = trans('app.mark_filled');

        $filled = "<span class='label label-success'>" . trans('app.filled') . "</span>";

        return response()->json(['is_filled' => $job->is_filled,'btn_title' => $btn_title ,'filled' => $filled]);
    }

    public function suggestion()
    {
        /**
         * Get All values
         */

        $degrees = []; $yearsExperience = [];
        // get resume
        $resume = Resume::with(['resumeEducation' ,'workExperience'])->where('id' ,'=' ,request('resume'))->first();
        // degree from education
        $resume->resumeEducation->each(function ($item) use(&$degrees){
            $degrees[] = $item->degree->id;
        });
        // years experience from workExperience
        $resume->workExperience->each(function ($item) use(&$yearsExperience){
            $yearsExperience[] = Carbon::createFromDate($item->date_from)->diffInYears(Carbon::createFromDate($item->date_to));
        });

        $name = $resume->headline;
        $geolocation_search = $resume->contact->geolocation_search;

        /**
         * find suggestion
         */
        $jobs = Job::whereHas('company',function ($query) {
            $query->where('user_id','<>',\Auth::id());
        })
        ->whereHas('degree',function ($query) use($degrees) {
            $query->whereIn('degree_id',$degrees);
        })
        ->whereHas('company.contact',function ($query) use ($geolocation_search) {
            $query->where('geolocation_search','REGEXP',replaceSearchRegex($geolocation_search));
        })
        ->where('name','REGEXP',replaceSearchRegex($name))
        ->where('experience_num',$yearsExperience)
        ->where('salary','>=',$resume->salary)
        ->where('is_filled','=',false)
        ->where('job_status','=','w')->get();

        return response()->json(['content' => view('site.position._suggestion',['jobs' => $jobs])->render()]);
    }
}
