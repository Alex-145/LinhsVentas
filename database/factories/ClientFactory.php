<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'dni_ruc' => $this->faker->unique()->numerify('###########'),
            'business_name' => $this->faker->company(),
            'phone_number' => $this->faker->phoneNumber(),
        ];
    }
}
