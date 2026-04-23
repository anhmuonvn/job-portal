<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            "confirm_password" => "required"
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
                 return redirect()->route('account.profile');
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
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view("front.account.profile",["user"=> $user]);
    }
    public function updateProfile(Request $request)
{
    $id = Auth::user()->id;

    $validator = Validator::make($request->all(), [
        'name'=>'required|string|min:5|max:20',
        'email'=> 'required|email|unique:users,email,'.$id.',id',
        'designation'=>'required',
        'mobile' => 'required|numeric|digits_between:9,11',
        'summary' => 'nullable|string|max:500',
        'cv' => 'nullable|mimes:pdf,doc,docx|max:2048'
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
            "image"=> "required|image",
        ]);
        if ($validator->passes())
        {
             $image = $request->image;
             $ext = $image->getClientOriginalExtension();
             $imageName = $id.'-'.time().'.'.$ext;
             $image->move(public_path('/profile_pic/'), $imageName);
             User::where('id',$id)->update(['image'=>$imageName]);
             session()->flash('success','Cập nhật ảnh thành công');
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

     public function logout()
    {
        Auth::logout();
        return redirect()->route("account.login");
    }

}
