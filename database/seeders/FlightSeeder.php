<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cgk = Airport::where('code', 'CGK')->first();
        $dps = Airport::where('code', 'DPS')->first();
        $sub = Airport::where('code', 'SUB')->first();
        $sin = Airport::where('code', 'SIN')->first();
        $kul = Airport::where('code', 'KUL')->first();
        $bkk = Airport::where('code', 'BKK')->first();

        $flights = [
            // Jakarta - Singapore
            [
                'flight_code' => 'GA-810',
                'airline' => 'Garuda Indonesia',
                'from_airport_id' => $cgk->id,
                'to_airport_id' => $sin->id,
                'departure_time' => Carbon::now()->addDays(3)->setTime(8, 0),
                'arrival_time' => Carbon::now()->addDays(3)->setTime(10, 30),
                'price' => 899000,
                'seat_class' => 'Economy',
                'status' => 'active',
            ],
            // Jakarta - Bali
            [
                'flight_code' => 'JT-901',
                'airline' => 'Lion Air',
                'from_airport_id' => $cgk->id,
                'to_airport_id' => $dps->id,
                'departure_time' => Carbon::now()->addDays(2)->setTime(6, 30),
                'arrival_time' => Carbon::now()->addDays(2)->setTime(9, 0),
                'price' => 499000,
                'seat_class' => 'Economy',
                'status' => 'active',
            ],
            // Surabaya - Bangkok
            [
                'flight_code' => 'QZ-703',
                'airline' => 'AirAsia',
                'from_airport_id' => $sub->id,
                'to_airport_id' => $bkk->id,
                'departure_time' => Carbon::now()->addDays(5)->setTime(14, 0),
                'arrival_time' => Carbon::now()->addDays(5)->setTime(17, 30),
                'price' => 1299000,
                'seat_class' => 'Economy',
                'status' => 'active',
            ],
            // Jakarta - Kuala Lumpur
            [
                'flight_code' => 'GA-820',
                'airline' => 'Garuda Indonesia',
                'from_airport_id' => $cgk->id,
                'to_airport_id' => $kul->id,
                'departure_time' => Carbon::now()->addDays(4)->setTime(10, 0),
                'arrival_time' => Carbon::now()->addDays(4)->setTime(13, 0),
                'price' => 799000,
                'seat_class' => 'Economy',
                'status' => 'active',
            ],
            // Bali - Singapore
            [
                'flight_code' => 'SQ-940',
                'airline' => 'Singapore Airlines',
                'from_airport_id' => $dps->id,
                'to_airport_id' => $sin->id,
                'departure_time' => Carbon::now()->addDays(6)->setTime(11, 30),
                'arrival_time' => Carbon::now()->addDays(6)->setTime(14, 30),
                'price' => 1599000,
                'seat_class' => 'Business',
                'status' => 'active',
            ],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}
