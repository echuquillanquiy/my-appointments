<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE Auth;

class FirebaseController extends Controller
{
    public function postToken(Request $request)
    {
		//$request->validate($rules);

    	$user = Auth::guard('api')->user();

    	if ($request->has('device_token')) 
    	{
    		$user->divece_token = $request->inpit('device_token');
    		$user->save();
    	}
    	
    }
}
