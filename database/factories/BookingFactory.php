<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'type' => $this->faker->randomElement(['internal','customer']),
            'bookingStart' => $this->faker->dateTimeBetween($startDate = '-7 days', $endDate = '+ 7days'),
            'bookingEnd' => $this->faker->dateTimeBetween($startDate = '-7 days', $endDate = '+ 7days'),
            'bookable_type' => '\App\Models\Customer',
            'bookable_id' => 1
        ];
    }
}
