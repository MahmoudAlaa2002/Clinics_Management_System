<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaypalAccountsSeeder extends Seeder {
    public function run(): void {
        DB::table('paypal_accounts')->insert([
            [
                'clinic_id'     => 1,
                'client_id'     => 'AfQuxo0yqV9LSjQvc94fZMTLswrqfIFrEAMDjNuv_N7X8afTw_sABvwmcrDBFFXb0xyJXcafidoFLAWw',
                'client_secret' => 'EDTrkv_Eq44ieuv5s8KOaT8ZBvUfcvmKplgV_FHGwnBvT6jMEfm48AXgtGMlSFgmv6lzBUSpZv6gQ9Zq',
                'is_live'       => 0, // Sandbox
                'currency'      => 'USD',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],

            [
                'clinic_id'     => 2,
                'client_id'     => 'AfQuxo0yqV9LSjQvc94fZMTLswrqfIFrEAMDjNuv_N7X8afTw_sABvwmcrDBFFXb0xyJXcafidoFLAWw',
                'client_secret' => 'EDTrkv_Eq44ieuv5s8KOaT8ZBvUfcvmKplgV_FHGwnBvT6jMEfm48AXgtGMlSFgmv6lzBUSpZv6gQ9Zq',
                'is_live'       => 0, // Sandbox
                'currency'      => 'USD',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
