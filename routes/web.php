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
Route::post("/apply-job", [JobsController::class,"applyJob"])->name("applyJob");
Route::group(["account"], function () {
    Route::group(["middleware"=> "guest"], function () {
            Route::get("/account/register", [AccountController::class,"registration"])->name("account.registration");
            Route::post("/account/process-register", [AccountController::class,"store"])->name("account.store");
            Route::post("/account/authenticate", [AccountController::class,"authenticate"])->name("account.authenticate");

            Route::get("/account/login", [AccountController::class,"login"])->name("account.login");
    });
    Route::group(["middleware"=> "auth"], function () {
        Route::get("/account/profile", [AccountController::class,"profile"])->name("account.profile");
        Route::post("/account/update-profile", [AccountController::class,"updateProfile"])->name("account.updateProfile");
        Route::post("/account/update-profile-pic", [AccountController::class,"updateProfilePic"])->name("account.updateProfilePic");
        Route::get("/account/logout", [AccountController::class,"logout"])->name("account.logout");
    });
});



