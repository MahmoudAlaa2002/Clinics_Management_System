<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosageFormSeeder extends Seeder
{
    public function run(): void{
        DB::table('dosage_forms')->insert([
            ['name' => 'Tablet'],
            ['name' => 'Capsule'],
            ['name' => 'Syrup'],
            ['name' => 'Injection'],
            ['name' => 'Suppository'],
            ['name' => 'Ointment'],
            ['name' => 'Cream'],
            ['name' => 'Drop'],
            ['name' => 'Spray'],
            ['name' => 'Powder'],
        ]);
    }
}
