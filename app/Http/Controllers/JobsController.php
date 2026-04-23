<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = Category::where("status",1)->get();
        $jobTypes = JobType::where("status",1)->get();
        $locations = Location::where("status",1)->get();
        $jobs = Job::where("status",1);
        //  $jobs = Job::where("status",1)->with(['jobType','category','location'])->orderBy('created_at','desc')->paginate(9);     
        // return view("front.jobs",["categories"=> $categories,
        // "locations"=> $locations,"jobTypes"=>$jobTypes,"jobs"=>$jobs]);
        //using keywords
        if(!empty($request->keyword))
        {
            $jobs=$jobs->where(function($query) use ($request) {
                $query->orWhere("title","like","%".$request->keyword."%");
                $query->orWhere("keywords","like","%".$request->keyword."%");
            });
        } 
        if(!empty($request->category)) 
        {
            $jobs= $jobs->where('category_id',$request->category);
        }   
        if(!empty($request->location)) 
        {
            $jobs= $jobs->where('location_id',$request->location);
        } 
        $jobTypeArray = [];
        if(!empty($request->jobType)) 
        {
            $jobTypeArray = explode(',',$request->jobType);
            $jobs= $jobs->whereIn('job_type_id',$jobTypeArray);
        } 
        if (!empty($request->experience)) {
            $exp = $request->experience;

            
            if ($exp == '1_3') {
                
                $jobs = $jobs->whereBetween('experience', [1, 3]);
            } 
            elseif ($exp == '3_5') {
                
                $jobs = $jobs->whereBetween('experience', [3, 5]);
            } 
            elseif ($exp == '5_10') {
                
                $jobs = $jobs->whereBetween('experience', [5, 10]);
            } 
            elseif ($exp == '10_plus') {
                
                $jobs = $jobs->where('experience', '>', 10);
            }
        }
        $jobs = $jobs->with(["jobType","location","category"])->orderBy("created_at","DESC")->paginate(9);
        return view("front.jobs",["categories"=> $categories,
        "locations"=> $locations,"jobTypes"=>$jobTypes,"jobs"=>$jobs,
        'jobTypeArray'=>$jobTypeArray]);
       
    }
    public function detail($id)
    {
   
    $job = Job::where(["id" => $id, "status" => 1])
        ->with(["location", "jobType", "category"])
        ->first();

    if ($job == null) {
        abort(404);
    }

    
    $relateJobs = Job::where('status', 1)
        ->where('category_id', $job->category_id) 
        ->where('id', '!=', $job->id)             
        ->with(['category', 'location'])
        ->latest()                                
        ->take(3)
        ->get();

    
    return view('front.jobDetail', [
        'job' => $job,
        'relateJobs' => $relateJobs 
    ]);
    }
    public function applyJob(Request $request){
          $id = $request->id;
          $job= Job::where('id', $id)->first();
          if ($job == null) {
            session()->flash('error','Công việc ko tồn tại');
              return response()->json([
                'status'=> false,
                'message'=> 'Công việc ko tồn tại'
              ]);
          }
          $employer_id = $job->user_id;
          $application = new JobApplication();
          $application->job_id = $id;
          $application->user_id =Auth::user()->id;
          $application->employer_id = $employer_id;
          $application->applied_date = now();
        //   $application->cv = Auth::user()->cv;
          $application->save();
          session()->flash('success','Bạn đã ứng tuyển thành công');
              return response()->json([
                'status'=> true,
                'message'=> 'Bạn đã ứng tuyển thành công'
              ]);
    }
}
