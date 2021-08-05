@extends(backpack_view('layouts.plain'))

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-4">
        <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3>
        <div class="card">
            <div class="card-body">
                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="control-label"
                            for="{{ $username }}">{{ config('backpack.base.authentication_column_name') }}</label>

                        <div>
                            <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}"
                                name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}"
                                data-init-function="bpFieldInitFlexiPhone">

                            @if ($errors->has($username))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first($username) }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>

                        <div>
                            <input type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                id="password">

                            @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ trans('backpack::base.login') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a>
    </div>
    @endif --}}
    {{-- @if (config('backpack.base.registration_open'))
                <div class="text-center"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
</div>
@endif --}}
</div>
</div>
@endsection

@push('after_styles')
<link rel="stylesheet" href="{{ asset('assets/intl-tel-input/css/intlTelInput.min.css') }}?v=0.0.2">
<style>
    .intl-tel-input {
        width: 100%;
    }
</style>
@endpush

@push('after_scripts')
<script src="{{ asset('assets/intl-tel-input/js/utils.js') }}?v=0.0.1"></script>
<script src="{{ asset('assets/intl-tel-input/js/intlTelInput.min.js') }}?v=0.0.1"></script>
<script>
    // $(function () {
        function rmInitializeFieldsWithJavascript(container) {
            var selector;
            if (container instanceof jQuery) {
                selector = container;
            } else {
                selector = $(container);
            }
            selector.find("[data-init-function]").not("[data-initialized=true]").each(function () {
                var element = $(this);
                var functionName = element.data('init-function');

                if (typeof window[functionName] === "function") {
                window[functionName](element);

                // mark the element as initialized, so that its function is never called again
                element.attr('data-initialized', 'true');
                }
            });
        }

        function itiCallback(elem, iti) {
            // console.log(iti.getNumber())
            elem.val(iti.getNumber());
        }

        function bpFieldInitFlexiPhone(element) {
            var iti = window.intlTelInput(element[0], {
                preferredCountries: ['kh'],
                autoFormat: false,
                // formatOnInit:true,
                formatOnDisplay: false,
                customPlaceholder: function () {
                    return '{{ trans('phone number') }}';
                },
            })

            // register country change select
            element.on('countrychange', function () {
                itiCallback(element, iti)
            })

            // register any keypress event
            element.on('keyup', function () {
                itiCallback(element, iti)
            })
        }

        rmInitializeFieldsWithJavascript('body');
        
</script>
@endpush