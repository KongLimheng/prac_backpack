<div class="row">
    @include('crud::fields.text', [
        'field' => [
            'name' => 'UserFullName',
            'label' => 'Full Name',
            'type' => 'text',
            'default' => $entry->FullName,
            'attributes' => [
                'disabled' => 'disabled',
            ],
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]

        ]
    ])
    @include('crud::fields.text', [
        "field" => [
            "name"  => "phone",
            "label" => 'phone',
            "type"  => 'text',
            "default" => $entry->phone,
            'attributes' => [
                // 'placeholder' => 'Some text when empty',
                // 'class'       => 'form-control some-class',
                // 'readonly'    => 'readonly',
                'disabled'    => 'disabled',
            ], // change the HTML attributes of your input
            'wrapper'   => [
                'class'      => 'form-group col-md-6'
            ],
        ]
    ])
    @include('crud::fields.password', [
        "field" => [
            "name"  => "password",
            "label" => 'Password <span style="color: red;">*</span>',
            "type"  => 'password',
            'wrapper'   => [
                'class'      => 'form-group col-md-6'
            ],
        ]
    ])
    @include('crud::fields.password', [
        "field" => [
            "name"  => "password_confirmation",
            "label" => 'Password Confirmation <span style="color: red;">*</span>',
            "type"  => 'password',
            'wrapper'   => [
                'class'      => 'form-group col-md-6'
            ],
        ]
    ])
</div>