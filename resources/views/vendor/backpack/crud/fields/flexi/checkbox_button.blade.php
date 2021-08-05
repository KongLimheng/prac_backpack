@if (isset($entry) && $entry))
    @php
        $checkValue = old($field['name']) ?? $entry->{$field['name']};
        $fieldName = $field['name']. '_button_checkbox';
        
    @endphp

    <div class="{{ $field['wrapper'] }}">
      <span class="{{ $fieldName }}">
        <button type="button" class="btn btn-sm {{ $checkValue == 1 ? 'btn-primary active' : '' }}" data-color="primary"><i class="state-icon la la-check-circle"></i>{{$field['label']}}</button>
        <input type="checkbox" class="d-none"
          data-init-function="bpFieldInitCheckbox"

          @if (old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? false)
                checked="checked"
          @endif
          @if (isset($field['attributes']))
              @foreach ($field['attribute'] as $attr => $value)
                  {{ $attr }} = "{{ $value }}"
              @endforeach
          @endif
          id="{{ $field['name'] }}_checkbox">
        <input type="hidden" name="{{ $field['name'] }}" value="{{  $checkValue ? 1 : 0 }}">

      </span>
    </div>
    
@else
  <div class="{{ $field['wrapper'] }}">
    <span class="{{$field['name']}}_button_checkbox">
        <button type="button" class="btn btn-sm" data-color="primary">{{$field['label']}}</button>
        <input type="checkbox" class="d-none" data-init-function="bpFieldInitCheckbox" 
            @if (old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? false)
                checked="checked"
            @endif 
            id="{{ $field['name'] }}_checkbox">
        <input type="hidden" name="{{ $field['name'] }}" value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? 0 }}">
    </span>
  </div>
@endif


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
@push('crud_fields_scripts')
    <script type="text/javascript">
      $(function (){
        var name = '.{{ $field['name'] }}_button_checkbox';
        $(name).each(function(){
          var $widget = $(this),
              $button = $widget.find('button'),
              $checkbox = $widget.find('input:checkbox'),
              color = $button.data('color'),
              setting = {
                on: {
                  icon: 'la la-check-circle'
                },
                off: {
                  icon: 'la la-circle'
                }
              }
          // event 
          $button.on('click', function(){
            $checkbox.prop('checked', !$checkbox.is(':checked'));;
            $checkbox.triggerHandler('change');
            updateDisplay();
          })
          $checkbox.on('change', function(){
            updateDisplay();
          })
          function updateDisplay(){
            var isChecked = $checkbox.is(':checked');

            // set the button's state
            $button.data('state', (isChecked) ? 'on' : 'off');
            // set the button's icon

            $button.find('.state-icon').removeClass().addClass('state-icon ' + setting[$button.data('state')].icon)
            // update the button's color
            var working_file = $(document).find('#working_field')
            var occupation = $(document).find('#occupation')
            var relationships = $(document).find('#relationships')
            if(isChecked){
              $button.removeClass('btn-light').addClass('btn-'+color+' active');
            }else{
              $button.removeClass('btn-'+color+' active').addClass('btn-light');
            }
          }

          function init(){
            updateDisplay();
            if($button.find('.state-icon').length == 0){
              $button.prepend('<i class="state-icon ' + setting[$button.data('state')].icon + '"></i> ');
            }
          }
          init();
        })
      });
    </script>
@endpush
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function bpFieldInitCheckbox(element) {
                var hidden_element = element.siblings('input[type=hidden]');

                // make sure the value is a boolean (so it will pass validation)
                if (hidden_element.val() === '') hidden_element.val(0);

                // set unique IDs so that labels are correlated with inputs

                // set the default checked/unchecked state
                // if the field has been loaded with javascript
                if (hidden_element.val() != 0) {
                  element.prop('checked', 'checked');
                } else {
                  element.prop('checked', false);
                }

                // when the checkbox is clicked
                // set the correct value on the hidden input
                element.change(function() {
                  if (element.is(":checked")) {
                    hidden_element.val(1).change();
                  } else {
                    hidden_element.val(0).change();
                  }
                })
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
