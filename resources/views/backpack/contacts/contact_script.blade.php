@push('after_scripts')
    @php
        function getErrorValue($key, $err, $entry)
        {
            return $err->first($key) ? old($key) : old($key) ?? $entry->{$key} ?? '';
        }

        $getType = getErrorValue('type', $errors, $entry ?? '');
    @endphp

    <script type="text/javascript">
        $(document).ready(function(){
            var initType = '{{ $getType }}';

            showHideInputByType(initType);

            $('select[name="type"]').change(function(){
                var value = $(this).val();
                showHideInputByType(value);
            })
            function showHideInputByType(value){
                if(value == 'Business'){
                    $('#account_id').removeClass('d-none');
                    $('#address_account').addClass('d-none');
                }else{
                    $('#account_id').addClass('d-none');
                    $('#address_account').removeClass('d-none');
                }
            }
        })
    </script>
@endpush