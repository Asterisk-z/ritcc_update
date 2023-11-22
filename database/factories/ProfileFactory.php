<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' =>  $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'email' => $this->faker->unique()->companyEmail(),
            'defaultPassword' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'status' => 1,
            'Package' => $this->faker->randomElement(["7", "9", "11"]),
            'Institution' => $this->faker->randomElement(["1", "2", "3", "4", "5"]),
            'type' => 'authoriser'
        ];
    }
}
