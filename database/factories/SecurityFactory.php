<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SecurityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'securityType' => $this->faker->randomElement(["BONDS", "T-BILLS", "CASH", "RITCC"]),
            'securityCode' => $this->faker->unique()->regexify('[A-Z]{3}[0-4]{3}'),
            'isinNumber' => $this->faker->unique()->regexify('[0-9]{7}'),
            'issuerCode' => $this->faker->randomElement(["NHJJN", "ZSCOH", "XOLRC", "CAZMS", "HDRJW"]),
            'issueDate' => $this->faker->date(),
            'transactionSettlementFeeRate' => $this->faker->randomDigit(),
            'status' => 1,
            'offerAmount' => 5000,
            'auctioneerRef' => 7,
            'createdBy' => 'msg.inputter@fmdqgroup.com',
            'createdDate' => $this->faker->date(),
        ];
    }
}
