<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    public function sendAll(Request $request)
    {
    	dd($request->all());
    }
}
