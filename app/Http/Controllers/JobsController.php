<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\Location;
use App\Models\SavedJob;
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
                // $query->orWhere("keywords","like","%".$request->keyword."%");
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
                ->with(["location", "jobType", "category","user"])
                ->first();

    if ($job == null) {
        abort(404);
    }
    $count = 0; // Mặc định là 0 dành cho khách chưa đăng nhập
    if(Auth::check()){
        $count = SavedJob::where([
             'user_id'=>Auth::user()->id,
             'job_id'=>$id
        ])->count();
    }
    
    $relateJobs = Job::where('status', 1)
        ->where('category_id', $job->category_id) 
        ->where('id', '!=', $job->id)             
        ->with(['category', 'location','user'])
        ->latest()                                
        ->take(3)
        ->get();
    // Ví dụ sửa lại trong Controller của bạn
        // $employerId = Auth::user()->id;

    // 2. Lấy danh sách các ứng viên đã ứng tuyển vào các công việc của Nhà tuyển dụng này
        $applications = JobApplication::with(['user', 'job'])
        ->where('job_id', $id) // Lọc theo công việc cụ thể
        ->whereHas('user', function($query) {
            // Lọc: Đảm bảo người ứng tuyển có vai trò là candidate (ứng viên)
            $query->where('role', 'candidate');
        })
        ->latest()
        ->get()->unique('user_id'); // Lấy danh sách ứng viên duy nhất (theo user_id)
    
    return view('front.jobDetail', [
        'job' => $job, "count"=>$count,
        'relateJobs' => $relateJobs,
        'applications'=>$applications 
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
          if (\Carbon\Carbon::parse($job->deadline)->isPast()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Rất tiếc, công việc này đã hết hạn nộp hồ sơ!'
                ]);
            }
          $isApplied = JobApplication::where('user_id', Auth::user()->id)
                               ->where('job_id', $id)
                               ->exists();
          if ($isApplied) {
            return redirect()->back()->with('error', 'Bạn đã ứng tuyển công việc này rồi!');
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
    public function saveJobs(Request $request){
        $id = $request->id;
        $job = Job::find( $id );
        if ($job == null) {
            session()->flash('error','Công việc ko tìm thấy');
            return response()->json([
                'status'=> false,
                
            ]);
        }
        $count = 0; // Mặc định là 0 dành cho khách chưa đăng nhập

        if (Auth::check()) {
            // Chỉ khi đã đăng nhập mới chạy dòng code lấy ID
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id'  => $id
            ])->count();
        }
        if ($count > 0) {
            session()->flash('error','Công việc này đã được lưu');
            return response()->json([
                'status'=> false,

            ]);
        }
        $savedJob = new SavedJob();
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();
        session()->flash('success','Bạn đã lưu việc làm thành công');
              return response()->json([
                'status'=> true,
                'message'=> 'Bạn đã việc làm thành công'
              ]);
    }
}
