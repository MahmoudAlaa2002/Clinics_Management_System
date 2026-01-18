<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClinicsSeeder extends Seeder{

    public function run(): void{

        DB::table('clinics')->insert([
            [
                'name'          => 'Clinic A',
                'location'      => 'Gaza City - Omar Al-Mukhtar Street',
                'email'         => 'clinicA@alshifaclinic.com',
                'phone'         => '0599001122',
                'opening_time'  => '08:00:00',
                'closing_time'  => '20:00:00',
                'working_days'  => json_encode(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']),
                'description'   => 'A general medical clinic that provides diagnostic and treatment services.',
                'status'        => 'active',
                'qr_image'      => 'assets\img\payments\1768555306_QR.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],

            [
                'name'          => 'Clinic B',
                'location'      => 'Gaza - Al-Nasr Neighborhood',
                'email'         => 'clinicB@alqudschildclinic.com',
                'phone'         => '0599332211',
                'opening_time'  => '09:00:00',
                'closing_time'  => '21:00:00',
                'working_days' => json_encode(['Saturday', 'Monday', 'Wednesday']),
                'description'   => 'Specialized clinic for children and pediatric medical care.',
                'status'        => 'active',
                'qr_image'      => 'assets\img\payments\1768555306_QR.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],

            [
                'name'          => 'Clinic C',
                'location'      => 'Gaza - Remal Area',
                'email'         => 'clinicC@alrazidental.com',
                'phone'         => '0599556677',
                'opening_time'  => '10:00:00',
                'closing_time'  => '16:00:00',
                'working_days' => json_encode(['Sunday', 'Tuesday', 'Thursday']),
                'description'   => 'Dental clinic offering cosmetic and surgical dental services.',
                'status'        => 'active',
                'qr_image'      => Null,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
