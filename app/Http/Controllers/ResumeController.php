<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Control\Entities\ApplyStatus;
use Modules\Control\Entities\Degree;
use Modules\Control\Entities\HourlyRate;
use Modules\Control\Entities\Job;
use Modules\Control\Entities\JobApply;
use Modules\Control\Entities\Resume;

class ResumeController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->only(['apply', 'send', 'owner', 'suggestion']);
    }

    public function index(Request $request ,Resume $resumes)
    {
        // load more owner resumes
        if(request()->ajax())
        {
            $resumes = Resume::where('user_id','=',\Auth::id())
                ->skip(request('prePage'))->take(request('page'))
                ->get();

            return response()->json(['content' => view('site.position._job_apply_resumes',['resumes' => $resumes ])->render() ]);
        }

        $resumes = $resumes->with(['resumeEducation']);

        // search location
        if($request->get('location',''))
        {
            $resumes = $resumes->whereHas('contact',function ($query) use($request) {
                $query->where('geolocation_search','like',replaceSearch($request->get('location','')));
            });
        }

        // search keyword
        $keyword = replaceSearch($request->get('keyword',''));
        if($request->get('keyword',''))
        {
            $resumes = $resumes->where('name','like',$keyword)
                ->orWhere('headline','like',$keyword)
                ->orWhere('short_description','like',$keyword)
                ->whereHas('skills',function ($query) use($request, $keyword){
                    $query->where('name','like',$keyword);
                })
                ->orWhereHas('tagList',function ($query) use($request, $keyword){
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
                    $resumes = $resumes->where(function ($query) use ($rate) {
                        $query->whereBetween('salary',$rate);
                    });
                else
                    $resumes = $resumes->orWhere(function ($query) use ($rate) {
                        $query->whereBetween('salary',$rate);
                    });
            }
        }

        // search degree
        $requestDegrees = $request->get('degree',[]);
        if(is_array($requestDegrees) && $requestDegrees)
        {
            $resumes = $resumes->whereHas('resumeEducation.degree',function ($query) use($request,$requestDegrees){
                $query->whereIn('id', $requestDegrees);
            });
        }

        $resumes = $resumes
            ->where('user_id','<>',\Auth::id())
            ->where('is_visible','=',true)
            ->orderBy('last_update','desc')
            ->paginate(5);

        $hourlyRate = HourlyRate::all();
        $degrees = Degree::all();

        return view('site.resume.resumes',compact('resumes','hourlyRate','degrees'));
    }

    public function owner()
    {
        $resumes = Resume::where('user_id','=',\Auth::id())
            ->where('is_visible','=',true)
            ->orderBy('last_update','desc')
            ->paginate(5);

        return view('site.resume.my_resumes',compact('resumes'));
    }

    public function show($id)
    {
        $resume = Resume::with(['resumeEducation','workExperience','skills','HasJobApply'])
            ->where('id', '=', $id)
            ->where('is_visible','=',true)
            ->first();

        return view('site.resume.resume-detail', compact('resume'));
    }

    public function apply($id)
    {
        $resume = Resume::where('id', '=', $id)
            ->where('is_visible','=',true)
            ->first();

        // dont't allow owner to apply its resume
        if(\Auth::id() == $resume->user_id)
            return;

        // take 2 from all
        $jobs = Job::with(['company.contact'])->whereHas('company',function ($query) {
            $query->where('user_id','=',\Auth::id());
        })->take(5)->get();

        return view('site.resume.resume-apply', compact('resume','jobs'));
    }

    public function send(Request $request,$id)
    {
        $this->validate($request,[
           'subject' => 'required',
           'message' => 'required',
           'job'     => 'required',
        ]);

        $ApplyStatusNew = ApplyStatus::where('code','=','new')->first();

        JobApply::create([
            'subject'   => $request->get('subject'),
            'message'   => $request->get('message'),
            'job_id'    => $request->get('job'),
            'apply_status_id' => $ApplyStatusNew->id,
            'resume_id' => $id,
            'user_id'   => \Auth::id(),
        ]);

        return \Redirect::intended(\RouteUrls::site_resumes());
    }

    public function suggestion()
    {
        /**
         * Get All values
         */
        $degrees = [];
        // get resume
        $job = Job::where('id' ,'=' ,request('job'))->first();
        // degree from education
        $job->degree->each(function ($item) use(&$degrees){
            $degrees[] = $item->id;
        });

        $name = $job->name;
        $experience_num = $job->experience_num;
        $geolocation_search = $job->company->contact->geolocation_search;

        /**
         * find suggestion
         */
        $resumes = Resume::where('user_id','<>',\Auth::id())
            ->whereHas('resumeEducation.degree',function ($query) use($degrees) {
                $query->whereIn('degree_id',$degrees);
            })
            ->whereHas('contact',function ($query) use ($geolocation_search) {
                $query->where('geolocation_search','REGEXP',replaceSearchRegex($geolocation_search));
            })
            ->where('headline','REGEXP',replaceSearchRegex($name))
            ->where('salary','<=',$job->salary)
            ->where('is_visible','=',true)
            ->leftJoin(DB::raw("(SELECT resume_id ,GROUP_CONCAT(timestampdiff(YEAR,date_from,date_to)) as years  
                from work_experience
                where timestampdiff(YEAR,date_from,date_to) = $experience_num
                GROUP BY resume_id
            ) as work_experience_year"),function ($join) use ($experience_num) {
                $join->on('resumes.id','=','work_experience_year.resume_id');
            })
            ->select(['*','years'])->get();

        return response()->json(['content' => view('site.resume._suggestion',['resumes' => $resumes])->render()]);
    }
}
