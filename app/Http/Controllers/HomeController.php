<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('status',1)
                        ->orderBy('name','ASC')->take(8)->get();
        $newCategories=  Category::where('status',1)
                        ->orderBy('name','ASC')->get();              
        $featuredJobs =  Job::where('status',1)->where('isFeature',1)
                         ->orderBy('created_at','DESC')
                        ->take(6)->get();  
        $latestJobs = Job::where('status',1)
                        ->orderBy('created_at','DESC')
                        ->take(6)->get();
        $locations = Location::where("status",1)->get();                                           
        return view("front.home",["categories"=> $categories,"locations"=>$locations
        ,'featuredJobs'=>$featuredJobs,'latestJobs'=>$latestJobs,"newCategories"=>$newCategories]);
    }
}
