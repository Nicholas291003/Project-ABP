<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Transportation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        // Ambil rute dan armada secara acak dari data seeder master
        $route = Route::inRandomOrder()->first();
        $transportation = Transportation::inRandomOrder()->first();
        
        $departureDate = $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d');

        return [
            'route_id' => $route->id,
            'transportation_id' => $transportation->id,
            'departure_date' => $departureDate,
            'departure_time' => $this->faker->randomElement(['08:00:00', '10:30:00', '14:00:00', '19:00:00', '21:30:00']),
            'arrival_time' => $this->faker->randomElement(['13:00:00', '15:30:00', '18:00:00', '05:30:00', '07:00:00']),
            // Harga = Tarif Dasar Rute + biaya tambahan acak (upcharge kelas kendaraan)
            'price' => $route->tarif_dasar + $this->faker->randomElement([0, 25000, 50000, 150000]),
            'total_seats' => $transportation->jumlah_kursi,
            'remaining_seats' => $this->faker->numberBetween(0, $transportation->jumlah_kursi),
        ];
    }
}