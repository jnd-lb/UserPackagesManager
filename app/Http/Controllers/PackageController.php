<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Package;


class PackageController extends Controller
{
    public function getUserPackages(){

        $data = Package::with(array('bundles' => function($query)
        {
             $query->where('bundles.plan_id', Auth::user()->plan_id);
        }))->get();

        return response()->json([
            'error' => false,
            "message"=>'The packages have been retreived sucessfully',
            "packages"=>$data
        ],
             200);
    }
}
