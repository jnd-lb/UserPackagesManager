<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/send",function(){
    $basic  = new \Vonage\Client\Credentials\Basic("4ef82e07", "EpPOgXeeax3AYyoR");
    $client = new \Vonage\Client($basic);
    $response = $client->sms()->send(
        new \Vonage\SMS\Message\SMS("96176452125", "JND", 'A text message sent using the Nexmo SMS API')
    );
    
    $message = $response->current();
    
    if ($message->getStatus() == 0) {
        echo "The message was sent successfully\n";
    } else {
        echo "The message failed with status: " . $message->getStatus() . "\n";
    }
});

//////////Auth APIs//////////
Route::post("/login","UserController@login");
Route::post("/verify-otp","UserController@verifyOtp");
Route::post("/signup","UserController@signup");
Route::post("/logout","UserController@logout");

////////Packages API/////////
//TODO JWT MIDDLEWARE
Route::post("/packages","PackagesController@getAllPackages");
   
 