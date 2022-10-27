<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\payment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\payment>
 */
class paymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = payment::class;
    public function definition()
    {
        return [
            'payment_id' =>fake()->name().rand(1,100) ,
            'amount' => rand(1,100),
            'currency' => Str::random(3),
            'status' => Str::random(3),
        ];
    }
}
