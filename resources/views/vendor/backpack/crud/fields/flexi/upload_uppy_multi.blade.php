
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

@if (isset($field['prefix']) || isset($field['suffix']))
    <div class="input-group">
@endif
@if (isset($field['prefix']))
    <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div>
@endif
<div class="row">
    <div class="col-md-12">
        <div id="upload">
            {{-- <attach-upload></attach-upload> --}}
        </div>
    
    </div>

</div>

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

@push('crud_fields_scripts')
    
@endpush