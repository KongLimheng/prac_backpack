<?php

namespace Database\Factories;

use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner'             =>  '1',
            'rating'            =>  'cold',
            'phone'             =>  '+85510108911',
            'name'              =>  $this->faker->randomElement([
                'Zillionholding',
                'Individual',
                'Zillennium-Personal',
            ]),
            'alias'             =>  'CADT',
            'account_number'    =>  '100',
            'website'           =>  "www.niptict.edu.kh",
            'ticker_symbol'     =>  'CADT',
            'ownership'         =>  $this->faker->randomElement([
                'Public',
                'Private',
                'Subsidiary',
                'Customer',
            ]),
            'industry'          =>  $this->faker->randomElement([
                'Education',
                'Telecommunications',
                'Technology',
                'Media',
            ]),
            'number_of_employees'=>  '12',
            'sic'               =>  'B20180021',
            'bank_branch'       =>  'KK1',
            'billing_address'   =>  'CC1',
            'email'             =>  'niptict@office.edu.kh',
            'address'           =>  'Tuol Kouk',
            'valid_until'       =>  Carbon::now(),
            'created_by'         =>  '1',
        ];
    }
}
