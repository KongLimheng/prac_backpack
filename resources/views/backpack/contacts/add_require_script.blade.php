@push('after_scripts')
    <script>
        $(function(){
            $('.is_vip_button_checkbox').click(function(){
                $('.vipRequired').toggleClass('required');
            });
            @if (old('is_vip') && isset($entry->is_vip) == '1')
                if($('input[name="is_vip"]').val()==1){
                    $(".vipRequired").toggleClass("required");
                }
            @endif
        })
    </script>
@endpush