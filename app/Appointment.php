<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
    	'description',
    	'specialty_id',
    	'doctor_id',
    	'patient_id',
    	'scheduled_date',
    	'scheduled_time',
    	'type'
    ];

    protected $hidden = [
        "specialty_id", "doctor_id", 'scheduled_time'
    ];

    protected $appends = [
        'scheduled_time_12'
    ];

    public function specialty()
    {
    	return $this->belongsTo(Specialty::class);
    }

    public function doctor()
    {
		return $this->belongsTo(User::class);
    }

    public function patient()
    {
    	return $this->belongsTo(User::class);
    }

    public function cancellation ()
    {
        return $this->hasOne(CancelledAppointment::class);
    }

    public function getScheduledTime12Attribute() {
		return (new Carbon($this->scheduled_time))->format('g:i A');
    }

    static public function createForPatient(Request $request, $patientId)
    {
        $data = $request->only([
          'description',
          'specialty_id',
          'doctor_id',
          'patient_id',
          'scheduled_date',
          'scheduled_time',
          'type'
        ]);
        
        $data['patient_id'] = $patientId;

        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');

        return self::create($data);
    }
}
