<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

///Will keep track for incoming requests
Route::group(['middleware' => ['requestLogging']], function() {

//////////Auth APIs//////////
Route::post("/verify-otp","AuthController@verifyOtp");
Route::post('/logout',"AuthController@logout");

//////// input validation👁️‍🗨️ //////// 
Route::group(['middleware' => ['validator']], function() {
    //Something went wrong with the Facades\Response inside the middleware
});
Route::post('/signup', 'AuthController@register');
Route::post('/login', 'AuthController@login');

////////Packages API (jwt🔒) ///////// 
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get("/getMyPackages","PackageController@getUserPackages");
});

});

Route::get("/logs","RequestLoggingController@getLogs");