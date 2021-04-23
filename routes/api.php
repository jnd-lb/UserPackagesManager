<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::post("/verify-otp","AuthController@verifyOtp");

Route::post('/signup', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

////////Packages API (jwt🔒) ///////// 
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post("/packages","PackagesController@getAllPackages");
});
