<!-- text input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

@if (isset($field['prefix']) || isset($field['suffix']))
    <div class="input-group">
@endif
@if (isset($field['prefix']))
    <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div>
@endif
<input type="text"
    name="{{ $field['name'] }}"
    data-init-function="bpFieldInitFlexiPhone"
    value="{{ old(square_brackets_to_dots($field['name'])) ?? ($field['value'] ?? ($field['default'] ?? '')) }}"
    {{-- @include('crud::fields.inc.attributes') --}}
    class="js-keypress-number form-control @error($field['name']) is-invalid @enderror">
@if (isset($field['suffix']))
    <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div>
@endif
@if (isset($field['prefix']) || isset($field['suffix']))
    </div>
@endif

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
@endif

@push('crud_fields_styles')
    <link rel="stylesheet"
        href="{{ asset('assets/intl-tel-input/css/intlTelInput.min.css') }}?v=0.0.2">
    <style>
        .intl-tel-input {
            width: 100%;
        }

    </style>
@endpush

@push('crud_fields_scripts')

    <script src="{{ asset('assets/intl-tel-input/js/utils.js') }}?v=0.0.1"></script>
    <script src="{{ asset('assets/intl-tel-input/js/intlTelInput.min.js') }}?v=0.0.1"></script>

    <script>
        function itiCallBack(elm, iti){ 
            elm.val(iti.getNumber());
        }
        function bpFieldInitFlexiPhone(elm) {
            var iti = window.intlTelInput(elm[0], {
                preferredCountries: ['kh'],
                autoFormat: false,
                // formatOnInit:true,
                formatOnDisplay: false,
                customPlaceholder: function() {
                    return '{{ $field['placeholder'] ?? ($field['label'] ?? 'Phone') }}';
                },
            })

            elm.on('changeCountry', function(){
                itiCallBack(elm, iti);
            })

            elm.on('keyup', function(){
                itiCallBack(elm, iti);
            })
        }
    </script>
@endpush
