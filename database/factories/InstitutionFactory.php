<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Z]{5}'),
            'institutionName' => $this->faker->company(),
            'address' => $this->faker->address(),
            'institutionEmail' => $this->faker->unique()->companyEmail(),
            'chiefDealerEmail' => $this->faker->unique()->companyEmail(),
            'status' => 0,
            'createdBy' => 'msg.inputter@fmdqgroup.com',
            'createdDate' => now(),
        ];
    }
}
