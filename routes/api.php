<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//////////Auth APIs//////////
Route::post("/verify-otp","AuthController@verifyOtp");

Route::post('/signup', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

////////Packages API (jwt🔒) ///////// 
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post("/packages","PackagesController@getAllPackages");
});
