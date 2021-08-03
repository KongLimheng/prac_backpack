<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class AccountIndustrySeeder extends Seeder
{
    use CreateTypeSeederTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        request()->merge(['disableParentChildrenEvent' => true]);

        $arr = [
            3 => [
                "name" => "Account Industry",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true
            ],
        ];

        $this->checkIfHaveParentAndCreate($arr);
        $this->forceDeleteWhereParentId([3]);
        $arrPropertyWaterResource = [
            [
                "name" => "Other",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Utilities",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Transportation",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Telecommunications",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Technology",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Shipping",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Retail",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Recreation",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Not For Profit",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Media",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Manufacturing",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Machinery",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Insurance",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Hospitality",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Healthcare",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Government",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Food & Beverage",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Finance",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "General Contractors",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Gas & Oil",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Garbage Collection/Waste Management",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Funeral Services",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Food Stores",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ], 
            [
                "name" => "Food Processing & Sales",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "	Farming",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Environmental",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Entertainment",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Engineering",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Energy",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Electronics",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Education",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Energy & Natural Resources",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Electronics Manufacturing & Equipment",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Electric Utilities",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Drug Manufacturers",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Doctors & Other Health Professionals",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Dental Clinic",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Consulting",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Construction",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Communications",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Chemicals",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Crop Production & Basic Processing",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Colleges, Universities & Schools",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Computer Software",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Coal Mining",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Clothing Manufacturing",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Chemical & Related Manufacturing",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Casinos & Gambling",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
            [
                "name" => "Car Manufacturers",
                "name_khm" => "",
                "code" => '',
                "auto_code" => true,
            ],
        ];
        $this->runLooping(3, $arrPropertyWaterResource , 'option');
    }
}
