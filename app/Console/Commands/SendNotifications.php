<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Appointment;

class SendNotifications extends Command
{
    protected $signature = 'fcm:send';
    protected $description = 'Enviar mensajes vía FCM';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Buscando citas médicas:');

        $now = Carbon::now();

        $headers = ['id', 'scheduled_date', 'scheduled_time', 'patient_id'];

        $appointmentsTomorrow = $this->getAppointments24Hours($now->copy());
        foreach($appointmentsTomorrow as $appointment)
        {
            $appointment->patient->sendFCM('No olvides tu cita mañana a esta hora.');
            $this->info('Mensaje FCM enviado al paciente (ID)' .$appointment->patient_id);
        }

        $this->table($headers, $appointmentsTomorrow->toArray());

        $appointmentsNextHour = $this->getappointmentsNextHour($now->copy());
        foreach($appointmentsNextHour as $appointment)
        {
            $appointment->patient->sendFCM('Tienes una cita en 1 hora. Te esperamos.');
            $this->info('Mensaje FCM enviado 24h antes al paciente (ID)' .$appointment->patient_id);
        }

        $this->table($headers, $appointmentsNextHour->toArray());
        
    }

    private function  getAppointments24Hours($now)
    {
        return Appointment::where('status', 'Confirmada')
        ->where('scheduled_date', $now->addDay()->toDateString())
        ->where('scheduled_time', '>=',$now->copy()->subMinutes(3)->toTimeString())
        ->where('scheduled_time', '<',$now->copy()->addMinutes(2)->toTimeString())
        ->get(['id', 'scheduled_date', 'scheduled_time', 'patient_id']));
    }

    private function getappointmentsNextHour($now)
    {
        return Appointment::where('status', 'Confirmada')
        ->where('scheduled_date', $now->addHour()->toDateString())
        ->where('scheduled_time', '>=',$now->copy()->subMinutes(3)->toTimeString())
        ->where('scheduled_time', '<',$now->copy()->addMinutes(2)->toTimeString())
        ->get(['id', 'scheduled_date', 'scheduled_time', 'patient_id']);
    }
}
