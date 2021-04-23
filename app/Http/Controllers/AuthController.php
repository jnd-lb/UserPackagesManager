<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $otp = rand ( 10000 , 99999 );
        $user = User::create([
             'name' => $request->name,
             'otp' =>$otp,
             "mobile_number" => $request->mobile_number,
             "plan_id" => rand( 1 , 2 )
         ]);

         $messageResult = $this->OTP($request->mobile_number,$otp);

         if($messageResult>0){
            return response()->json([
                 "error"=>false,
                 "message"=>"message has been sent please check your phone"
             ],200);
         }else{
            return response()->json([
                "error"=>true,
                "message"=>"something went wrong while sending the msg"
            ],400);
         }
    }

    public function sendOTP($number,$otp){
        // it is not smart to leave the private key here but I left it to faciltate to app testing
        $basic  = new \Vonage\Client\Credentials\Basic("4ef82e07", "EpPOgXeeax3AYyoR");
        $client = new \Vonage\Client($basic);
        $response = $client->sms()->send(
        new \Vonage\SMS\Message\SMS($number, "JND", 'Your code is: '.$otp)
    );
    
    $message = $response->current();
    
    if ($message->getStatus() == 0) {
        return true;
    }
    
    return false;
    }

    public function verifyOtp(Request $request){
        $user = User::where("otp",$request->otp)
        ->where("mobile_number",$request->mobile_number)->first();
        
        if($user){
            $user->update(['verified' => 1]);
           return response()->json([
                "error"=>false,
                "message"=>"mobile has been verified"
            ],200);
        }else{
            return response()->json([
                "error"=>true,
                "message"=>"mobile has not been verified. Mobile number or the code is wrong"
            ],400);
        }
    }
    
    public function login(Request $request)
    {
        $user = User::where("mobile_number",$request->mobile_number)->first();
        //check if mobile exist
        if(!$user){
            return response()->json([
                'error' => true,
                "message"=>'No such mobile phone'], 400);
        }

        //check if he is verified
        if(!$user->verified){
            return response()->json([
                'error' => true,
                "message"=>'The mobile number is not verified'], 400);
        }

        if(!$user->password){
            if(!$request->password){
                return response()->json([
                    'error' => true,
                    "message"=>'You need to set a new password. Please provide us with a password'], 400);
            }
            
            $user->password= $request->password;
            $user->save();
        }else{
            if(!$request->password){
                return response()->json([
                    'error' => true,
                    "message"=>'Password is required'], 400);
            }
        }

        $credentials = request(['mobile_number',"password"]);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => true,
                "message"=>'Unauthorized'], 400);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            "error"=>false,
            'message' => 'Successfully logged out'],200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "error"=>false,
            "message"=>"Logged in succesfully",
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ],200);
    }

}