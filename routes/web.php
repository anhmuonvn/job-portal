<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get("/", [HomeController::class,"index"])->name("home");
Route::get("/jobs", [JobsController::class,"index"])->name("jobs");
Route::get("/jobs/detail/{id}", [JobsController::class,"detail"])->name("jobDetail");
// Route::get("/save-jobs", [JobsController::class,"saveJobs"])->name("account.saveJobs");



Route::group(["account"], function () {
    Route::group(["middleware"=> "guest"], function () {
            Route::get("/account/register", [AccountController::class,"registration"])->name("account.registration");
            Route::post("/account/process-register", [AccountController::class,"store"])->name("account.store");
            Route::post("/account/authenticate", [AccountController::class,"authenticate"])->name("account.authenticate");
            
            Route::get("/account/login", [AccountController::class,"login"])->name("account.login");
    }); 
    Route::group(["middleware"=> "auth"], function () {
         Route::post("/update-profile-pic", [AccountController::class,"updateProfilePic"])->name("account.updateProfilePic");
        Route::group(["middleware" => "checkRole:candidate"], function() {
            Route::get("/profile", [AccountController::class,"profile"])->name("account.profile");
            Route::get("/my-job-applications", [AccountController::class,"myJobApplications"])->name("account.myJobApplications");
            Route::post("/save-jobs", [JobsController::class,"saveJobs"])->name("saveJobs");
            Route::get("/my-save-jobs", [AccountController::class,"mySaveJobs"])->name("account.mySaveJobs");
            Route::post("/update-profile", [AccountController::class,"updateProfile"])->name("account.updateProfile");
            Route::get("/company-detail/{id}", [AccountController::class,"companyDetail"])->name("account.companyDetail");
            Route::post("/apply-job", [JobsController::class,"applyJob"])->name("applyJob");
        });
        Route::group(["middleware" => "checkRole:employer"], function() {
            Route::get("/company", [AccountController::class,"company"])->name("account.company");
            Route::put("/account/update-company", [AccountController::class,"updateCompany"])->name("account.updateCompany");
            Route::get("/account/create-job", [AccountController::class,"createJob"])->name("account.createJob");
            Route::post("/save-job", [AccountController::class,"saveJob"])->name("account.saveJob");
            Route::post("/update-job/{jobId}", [AccountController::class,"updateJob"])->name("account.updateJob");
            // Route::post("/update-logo", [AccountController::class,"updateProfilePic"])->name("account.updateProfilePic");
            Route::get("/account/my-jobs", [AccountController::class,"myJobs"])->name("account.myJobs");
            Route::get("/account/edit-job/{jobId}", [AccountController::class,"editJob"])->name("account.editJob");
            Route::post("/delete-job", [AccountController::class,"deleteJob"])->name("account.deleteJob");
            Route::get("/account/my-jobs", [AccountController::class,"myJobs"])->name("account.myJobs");
            Route::get("/account/my-applicants", [AccountController::class,"showApplicants"])->name("account.myApplicants");
            Route::get("/account/candidate-detail/{id}", [AccountController::class,"showCandidate"])->name("account.showCandidate");
        });
       
       
        Route::get("/account/logout", [AccountController::class,"logout"])->name("account.logout");
        // Route::get("/account/my-job-applications", [AccountController::class,"myJobApplications"])->name("account.myJobApplications");
        
        // Route::get("/account/save-jobs", [AccountController::class,"saveJobs"])->name("account.saveJobs");
        // Route::post("/account/remove-job-save", [AccountController::class,"removeSaveJob"])->name("account.removeSaveJob");
    });
});



