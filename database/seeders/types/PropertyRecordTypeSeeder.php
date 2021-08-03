<?php

namespace Database\Seeders\types;

use App\Traits\Type\CreateTypeSeederTrait;
use Illuminate\Database\Seeder;

class PropertyRecordTypeSeeder extends Seeder
{
    use CreateTypeSeederTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->forceDeleteWhereParentId([1]);
        request()->merge(['disableParentChildrenEvent' => true]);

        $types = [
            [
                'name' => 'Land',
                'name_khm' => 'ដី',
                'code' => '',
                'auto_code' => true,
                'child' => [
                    [
                        'name' => 'Vacant Land',
                        'name_khm' => 'ដីទំនេរ',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Improved Land',
                                'name_khm' => 'ដីត្រូវបានរៀបចំរួចរាល់',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Unimproved Land',
                                'name_khm' => 'ដីទំនេរមិនទាន់រៀបចំ',
                                'code' => '',
                                'auto_code' => true,
                            ]
                        ]
                    ],
                    [
                        'name' => 'Agricultural Land',
                        'name_khm' => 'ដីកសិកម្ម',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Farms',
                                'name_khm' => '',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Ranches',
                                'name_khm' => '',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Orchards',
                                'name_khm' => '',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Timberland',
                                'name_khm' => '',
                                'code' => '',
                                'auto_code' => true,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Building',
                'name_khm' => 'អគារ',
                'code' => '',
                'auto_code' => true,
                'child' => [
                    [
                        'name' => 'Condominium',
                        'name_khm' => 'ខុនដូរ',
                        'code' => '',
                        'auto_code' => true,
                    ],
                    [
                        'name' => 'Apartment',
                        'name_khm' => 'អាផាតមិន',
                        'code' => '',
                        'auto_code' => true,
                    ],
                    [
                        'name' => 'Wooden House/Dwelling',
                        'name_khm' => 'សំណង់ផ្ទះឈើ',
                        'code' => '',
                        'auto_code' => true,
                    ],
                    [
                        'name' => 'Co-Ownership Property',
                        'name_khm' => 'ផ្ទះសហកម្មសិទ្ធិ',
                        'code' => '',
                        'auto_code' => true,
                    ]
                ]
            ],
            [
                'name' => 'Land and Building',
                'name_khm' => 'ដី​ និង​ អគារ',
                'code' => '',
                'auto_code' => true,
                'child' => [
                    [
                        'name' => 'Agricultural Property',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ កសិកម្ម',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Farms',
                                'name_khm' => '	ដីស្រែចម្ការ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Ranches',
                                'name_khm' => '	ដីកសិដ្ឋានចិញ្ចឹមសត្វ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Orchards',
                                'name_khm' => 'ដីចម្ការផ្លែឈើ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Timberland',
                                'name_khm' => 'ដីព្រៃឈើ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Mango',
                                'name_khm' => 'ផ្លែស្វាយ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Pepper',
                                'name_khm' => 'ម្រេច',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Cashew',
                                'name_khm' => 'ផ្លែស្វាយចន្ទី',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Durian',
                                'name_khm' => 'ផ្លែទុរេន',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Longan',
                                'name_khm' => 'ផ្លែមាន',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Rubber Plantation',
                                'name_khm' => 'ចម្ការកៅស៊ូ',
                                'code' => '',
                                'auto_code' => true,
                            ]
                        ]
                    ],
                    [
                        'name' => 'Residential Property',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ លំនៅដ្ឋាន',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Detached House ( Villa )',
                                'name_khm' => 'ផ្ទះវិឡា',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Simi Detached House ( Twin Villa )',
                                'name_khm' => 'ផ្ទះវិឡាភ្លោះ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Terraced House ( Flat House )',
                                'name_khm' => 'ផ្ទះល្វែង',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Linked House',
                                'name_khm' => 'ផ្ទះវិឡាកូនកាត់',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Dwelling',
                                'name_khm' => 'ផ្ទះឈើ រឺ ផ្ទះថ្ម',
                                'code' => '',
                                'auto_code' => true,
                            ],
                        ]
                    ],
                    [
                        'name' => 'Commercial Property',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ ពាណិជ្ជកម្ម',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Hotel',
                                'name_khm' => 'សណ្ឋាគារ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Guest House',
                                'name_khm' => 'ផ្ទះសំណាក់',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Restaurant',
                                'name_khm' => 'ភោជនីយដ្ឋាន',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Retail Space',
                                'name_khm' => 'ហាងទំនិញ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Shopping Centers',
                                'name_khm' => 'មជ្ឈមណ្ឌលពាណិជ្ជកម្ម',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Entertainment Building',
                                'name_khm' => 'មជ្ឈមណ្ឌលកំសាន្ត',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Gasoline Station',
                                'name_khm' => 'ស្ថានីយ៍ប្រេងឥន្ធនៈ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Mixed Use Building',
                                'name_khm' => 'អគារពហុមុខងារ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Parking Facilities',
                                'name_khm' => 'ចំណតរថយន្ត',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Shop House',
                                'name_khm' => 'ផ្ទះអាជីវកម្ម',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Resort',
                                'name_khm' => 'រីហ្សត',
                                'code' => '',
                                'auto_code' => true,
                            ],
                        ]
                    ],
                    [
                        'name' => 'Industrial Property',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ​ ឧស្សាហកម្ម',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Factory',
                                'name_khm' => 'រោងចក្រ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Warehouse',
                                'name_khm' => 'ឃ្លាំង',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Power Plants',
                                'name_khm' => 'រោងចក្រផលិតថាមពល',
                                'code' => '',
                                'auto_code' => true,
                            ],
                        ]
                    ],
                    [
                        'name' => 'Specialized Property',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ ឯកទេសកម្ម',
                        'code' => '',
                        'auto_code' => true,
                        'child' => [
                            [
                                'name' => 'Government Institution',
                                'name_khm' => 'ស្ថាប័នរដ្ឋាភិបាល',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'School',
                                'name_khm' => 'សាលារៀន',
                                'code' => '',
                                'auto_code' => true,
                            ],
                            [
                                'name' => 'Hospital',
                                'name_khm' => 'មន្ទីរពេទ្យ',
                                'code' => '',
                                'auto_code' => true,
                            ],
                        ]
                    ],
                    [
                        'name' => 'Mixed-use',
                        'name_khm' => 'អចលនទ្រព្យប្រភេទ ចម្រុះ',
                        'code' => '',
                        'auto_code' => true,
                    ],
                ]
            ],
        ];

        $this->runLooping(1, $types, 'all');
    }
}
