<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\Location;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    //
    public function registration()
    {
        return view("front.account.registration");
    }
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            "email"=> "required|email|unique:users,email",
            "password"=> "required|min:5|same:confirm_password",
            "confirm_password" => "required",
            "role" => "required|in:candidate,employer"
            
        ]);
        if ($validator->fails())
        {
            return response()->json([
                "status"=>false,
                "errors"=>$validator->errors()
            ]);
        }
        else
        {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make( $request->password );
            $user->role = $request->role;
            $user->save();
            session()->flash("success","Đăng kí tài khoản thành công");
            return response()->json([
                "status"=>true,
                "errors"=>[]
            ]);
        }        
    }
    public function login()
    {
        return view("front.account.login");
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            "email"=> "required|email",
            "password"=> "required",
           
        ]);
        if ($validator->passes())
        {
            if(Auth::attempt(["email"=> $request->email,"password"=> $request->password ]))
            {
                if($request->user()->role=="candidate")
                    return redirect()->route('account.profile');
                if($request->user()->role=="employer")
                    return redirect()->route('account.company');
            }
            else
            {
                return redirect()->route('account.login')->with("error","Mk/Password ko đúng");
            }        
        } 
        else
        {
            return redirect()->route('account.login')
                               ->withErrors( $validator->errors() )
                               ->withInput( $request->only('email') );
        }       
        

    }
    public function company()
    {
        $id = Auth::user()->id;
        $locations = Location::where('status',1)->get();
        $company = User::where('id', $id)->with('location')->first();
        return view("front.account.company",["company"=> $company,"locations"=> $locations ]);
    }
    public function updateCompany(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
                'company_name'=>'required|string|min:5|max:20',
                'company_location'=> 'required',
                'company_website'=>'required',
                'company_size'=>'required',
                
                'company_description' => 'required|string|max:500',
                
                'company_address'=>'nullable|string'

        ]);
        if ($validator->fails()) {
            return response()->json([
            "status"=>false,
            "errors"=>$validator->errors()
        ]);
        }
        $company = User::find($id);
        $company->company_name = $request->company_name;
        $company->location_id = $request->company_location;
        $company->company_location = $request->company_location;
        $company->company_website = $request->company_website;
        $company->company_address = $request->company_address;
        $company->company_description = $request->company_description;
        $company->company_size = $request->company_size;
        $company->save();
        session()->flash('success','Cập nhật thông tin công ty thành công');

    return response()->json([
        "status"=>true,
        "errors"=>[]
    ]);
    }
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view("front.account.profile",["user"=> $user]);
    }
    public function showCandidate( $id)
    {
        $user = User::findOrFail( $id );
        return view("front.account.profile",["user"=> $user]);
    }
    public function companyDetail( $id)
    {
        $company = User::findOrFail( $id );
        $locations = Location::where('status',1)->get();
        return view("front.account.company",["company"=> $company,"locations"=> $locations]);
    }
    public function updateProfile(Request $request)
    {
    $id = Auth::user()->id;

    $validator = Validator::make($request->all(), [
        'name'=>'required|string|min:3|max:20',
        'email'=> 'required|email|unique:users,email,'.$id.',id',
        'designation'=>'required',
        'mobile' => 'required|numeric|digits_between:9,11',
        'summary' => 'nullable|string|max:500',
        'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
        'address'=>'nullable|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            "status"=>false,
            "errors"=>$validator->errors()
        ]);
    }

    $user = User::find($id);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->designation = $request->designation;
    $user->mobile = $request->mobile;
    $user->summary = $request->summary;
    $user->address = $request->address;

    // Upload CV
    if ($request->hasFile('cv')) {

        // xoá file cũ
        if ($user->cv && file_exists(public_path('uploads/cv/'.$user->cv))) {
            unlink(public_path('uploads/cv/'.$user->cv));
        }

        $file = $request->file('cv');
        $filename = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('uploads/cv'), $filename);

        $user->cv = $filename;
    }

    $user->save();

    session()->flash('success','Cập nhật hồ sơ thành công');

    return response()->json([
        "status"=>true,
        "errors"=>[]
    ]);
}
    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;
        
        $validator = Validator::make($request->all(), [
            "image" => "required|image",
        ]);
        if ($validator->passes())
        {
             $image = $request->image;
             $ext = $image->getClientOriginalExtension();
             $imageName = $id.'-'.time().'.'.$ext;
             if(Auth::user()->role=="employer")
             {
                $folder = '/company_logos/';
                $dbColumn = 'company_logo'; 
                $message = 'Cập nhật logo công ty thành công!';
             } 
              else
             {
                $folder = '/profile_pic/';
                $dbColumn = 'image'; 
                $message = 'Cập nhật ảnh đại diện thành công!';
             }
             // Xóa ảnh cũ trong đúng thư mục và đúng cột của User đó
            $oldImage = ($dbColumn == 'company_logo') ? Auth::user()->company_logo : Auth::user()->image;
            if (!empty($oldImage)) {
                File::delete(public_path($folder . $oldImage));
            }  
             $image->move(public_path($folder), $imageName);
             User::where('id',$id)->update([$dbColumn=>$imageName]);
             session()->flash('success',$message);
             return response()->json
            ([
                "status"=>true,
                "errors"=>[]
            ]);
        } 
        else
        {
            return response()->json
            ([
                "status"=>false,
                "errors"=>$validator->errors()
            ]);
        }       
    }
    public function createJob(){
         
         $categories = Category::where("status",1)->get();
         $jobTypes = JobType::where("status",1)->get();
         
        return view("front.account.job.create",
        ["categories"=>$categories,"jobTypes"=>$jobTypes]);
    }
    public function saveJob(Request $request){
        
        $validator = Validator::make($request->all(), [
            'title'=>'required|string|min:5|max:100',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=> 'required|integer',
            'description'=>'required',
            'responsibility'=>'required',
            'benefits'=>'required',
            'qualifications'=>'required',
            'experience'=>'required',
            'deadline'=>'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"=>false,
                "errors"=>$validator->errors()
            ]);
        }
        else {
            $job = new Job();
            $job->user_id = Auth::user()->id;
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->address = Auth::user()->company_address;
            $job->location_id = Auth::user()->location_id;  
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->description = $request->description;
            $job->responsibility = $request->responsibility;
            $job->benefits = $request->benefits;
            $job->qualifications = $request->qualifications;
            $job->experience = $request->experience;
            $job->keywords = $request->keywords;
            $job->deadline = $request->date("deadline");
            $job->save();
            session()->flash('success','Đăng tin tuyển dụng thành công');
            return response()->json([
                "status"=>true,
                "errors"=>[]
            ]);
        }
    }

    public function editJob(Request $request, $id){
         $categories = Category::where("status",1)->get();
         $jobTypes = JobType::where("status",1)->get();
            $job = Job::where("id",$id)->where("user_id",Auth::user()->id)->first();
            if($job==null){
                abort(404);
            }
        return view("front.account.job.edit",[
            "categories"=>$categories,
            "jobTypes"=>$jobTypes,
            "job"=>$job
            
        ]);
    }
    public function updateJob(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title'=>'required|string|min:5|max:100',
            'category'=>'required',
            'jobType'=>'required',
            'vacancy'=> 'required|integer',
            'description'=>'required',
            'responsibility'=>'required',
            'benefits'=>'required',
            'qualifications'=>'required',
            'experience'=>'required',
            'deadline'=>'required|date',
        ]);
         if($validator->fails()){
            return response()->json([
                "status"=>false,
                "errors"=>$validator->errors()
            ]);
        }
        
        
        else {
            $job = Job::find($id);
            $job->user_id = Auth::user()->id;
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->address = Auth::user()->company_address;
            $job->location_id = Auth::user()->location_id;  
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->description = $request->description;
            $job->responsibility = $request->responsibility;
            $job->benefits = $request->benefits;
            $job->qualifications = $request->qualifications;
            $job->experience = $request->experience;
            $job->keywords = $request->keywords;
            $job->deadline = $request->date("deadline");
            $job->save();
            session()->flash('success','Cập nhật tin tuyển dụng thành công');
            return response()->json([
                "status"=>true,
                "errors"=>[]
            ]);
        }
    }
    public function deleteJob(Request $request)
    {
        $job = Job::where(['id'=>$request->jobId,'user_id'=>Auth::user()->id])->first();
        if($job==null){
            session()->flash('error','Tin tuyển dụng ko thấy hoặc bị xóa');
            return response()->json(['status'=>true]);
        }
        Job::where('id',$request->jobId)->delete();
        session()->flash('success','Xóa tin tuyển dụng thành công');
        return response()->json(['status'=>true]);
    }
    public function myJobs(){
        $jobs = Job::where("user_id",Auth::user()->id)->with(['applications','jobType'])->paginate(5);
        return view("front.account.job.my-jobs", ["jobs"=>$jobs]);
    }
     public function logout()
    {
        Auth::logout();
        return redirect()->route("account.login");
    }
    public function myJobApplications(){
        $jobApplications = JobApplication::where("user_id",Auth::user()->id)->with(["user","job"])->get();
        return view('front.account.job.my-job-applications',
                     ['jobApplications'=>$jobApplications]);
    }
    // public function removeJobs(Request $request)
    // {
    //     $jobApplication = JobApplication::where(['id'=>$request->id,'user_id'=>Auth::user()->id])->first();
    //     if($jobApplication==null){
    //         session()->flash('error','Việc ứng tuyển này ko thấy');
    //         return response()->json(['status'=>false]);
    //     }
    //     JobApplication::find($request->id)->delete();
    //     session()->flash('success','Xóa thành công việc ứng tuyển');
    //     return response()->json(['status'=>true]);
    // }
    public function mySaveJobs(){
        $saveJobs = SavedJob::where([['user_id',Auth::user()->id]])->with(['job','user'])->get();
        return view('front.account.job.my-save-jobs',
                      [ 'saveJobs'=>$saveJobs]);
    }
    // public function removeSaveJob(Request $request)
    // {
    //     $saveJob = SavedJob::where(['id'=>$request->id,'user_id'=>Auth::user()->id])->first();
    //     if($saveJob==null){
    //         session()->flash('error','Việc này đã lưu ko thấy');
    //         return response()->json(['status'=>false]);
    //     }
    //     SavedJob::find($request->id)->delete();
    //     session()->flash('success','Xóa thành công việc đã lưu');
    //     return response()->json(['status'=>true]);
    // }
    public function showApplicants(Request $request)
    {
        $employerId = Auth::user()->id;
        $applications = JobApplication::with(['user','job'])->whereHas('job', function($query) use ($employerId){
            $query->where('user_id', $employerId);
        })->latest()->paginate(2);
        return view('front.account.job.my-applicants'
        ,[
            'applications'=>$applications
        ]);
    }
}
