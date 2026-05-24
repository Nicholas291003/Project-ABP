<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        // Mengambil jadwal acak untuk mengambil harga tiket
        $schedule = Schedule::inRandomOrder()->first();
        // Mengambil user dengan role penumpang acak
        $passenger = User::where('role', 'penumpang')->inRandomOrder()->first();
        
        $totalPassengers = $this->faker->numberBetween(1, 4);

        return [
            'user_id' => $passenger->id,
            'schedule_id' => $schedule->id,
            'order_code' => 'TKT-' . strtoupper($this->faker->unique()->bothify('??###?')),
            'total_passengers' => $totalPassengers,
            'total_price' => $schedule->price * $totalPassengers,
            'status' => $this->faker->randomElement(['pending', 'lunas', 'dibatalkan']),
        ];
    }
}