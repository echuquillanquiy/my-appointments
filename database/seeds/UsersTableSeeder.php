<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
    		'name' => 'Eduardo Chuquillanqui',
	        'email' => 'echuquillanquiy@gmail.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('123456'),
	        'role' => 'admin'
    	]);

        User::create([
            'name' => 'Paciente Test',
            'email' => 'paciente1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'role' => 'patient'
        ]);

        User::create([
            'name' => 'Médico Test',
            'email' => 'medico1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'role' => 'doctor'
        ]);

        factory(User::class, 50)->states('patient')->create();
    }
}
