<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount'=>$this->faker->randomFloat($maxDecimals = 2, $min = 15, $max = 500),
            'payed_at'=>$this->faker->dateTimeBetween($startDate= '-1 year', $endDate= 'now', $timezone= null),
            'order_id'=> $this->faker->numberBetween(1, 20),
        ];
    }
}
