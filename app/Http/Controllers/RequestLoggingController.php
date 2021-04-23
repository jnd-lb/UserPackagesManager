<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestLogging;
class RequestLoggingController extends Controller
{
  public function getLogs(){
      $data=RequestLogging::all();
  
      return response()->json([
          'error' => false,
          "message"=>'all the logs has been listed',
          "logs"=>$data,
          
      ],
           200);
  } 
}
