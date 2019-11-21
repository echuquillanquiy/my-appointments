<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleServiceInterface;

use App\Workday;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function hours(Request $request, ScheduleServiceInterface $scheduleService)
    {
    	//dd($request->all());

    	$rules = [
    		'date' => 'required|date_format:"Y-m-d"',
    		'doctor_id' => 'required|exists:users,id'
    	];
    	$request->validate($rules);

    	$date = $request->input('date');    	
    	$doctorId = $request->input('doctor_id');

        return $scheduleService->getAvailableIntervals($date, $doctorId);

    }
}
