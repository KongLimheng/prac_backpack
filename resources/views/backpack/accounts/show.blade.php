@extends('backpack::blank')

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <a href="javascript: window.print();" class="btn btn-primary btn-sm float-right"><i class="la la-print"></i></a>
        <a href="{{ url($crud->route . '/' . $entry->getKey() . '/edit') }}" class="btn btn-warning btn-sm float-right mx-2"><i class="la la-edit"></i></a>
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')) . ' ' . $crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row pt-4">
        <div class="col-md-3">
            <div class="box box-box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title text-center">Company Information</h3>
                </div>
                <div class="box-body">
                    <div class="box-body box-profile p-0">
                        @if (!$entry->logo)
                            <img src="{{ asset('uploads/profile/R.png') }}" alt="..."
                                class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                        @else
                            <img src="{{ asset($entry->logo) }}" alt="..."
                                class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                        @endif
                    </div>

                    <div class="text-center">
                        <div class="profile-username text-center text-capitalize text-break p-5">
                            {{ $entry->name }}
                        </div>
                    </div>
                    <ul class="list-group pb-2">
                        <li class="list-group-item border-left-0 border-right-0">
                            <em class="nav-icon la la-phone mr-1"></em>
                            <a href="tel::" class="text-break">{{ $entry->phone }}</a>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <em class="nav-icon la la-envelope mr-1"></em>
                            <a class="text-dark text-break" href="mailto:{{ $entry->email }}">{{ $entry->email }}</a>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-industry mr-1"></em></strong>
                            <span class="text-dark text-break">{{ $entry->website }}</span>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-id-card mr-1"></em></strong>
                            <span class="text-dark text-break">{{ optional($entry->owners)->name }}</span>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-building mr-1"></em></strong>
                            <span class="text-dark text-break">{{ $entry->bank_branch }}</span>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-calendar-day mr-1"></em></strong>
                            <span class="text-dark text-break">{{ $entry->created_at }}</span>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-rss mr-1"></em></strong>
                            <a href="" target="_blank"></a>
                        </li>
                        <li class="list-group-item border-left-0 border-right-0">
                            <strong><em class="la la-star mr-1"></em></strong>
                            <span class="text-dark text-break"></span>
                        </li>
                    </ul>
                    <a href="{{ url($crud->route . '/' . $entry->getKey() . '/edit') }}"
                        class="btn btn-primary btn-block"><strong>Edit</strong></a>
                </div>
            </div>
        </div>
        <div class="col-md-9 pl-0">
            <div class="mnb-custom d-flex flex-wrap w-100 mb-3 bg-white">
                <div class="d-flex justify-content-between flex-wrap w-100">
                    <ul class="nav" role="tabTitle">
                        <li class="nav-item">
                            <a class="nav-link" style="cursor: pointer;"><i class="la la-home"></i>
                                Information
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change active" data-toggle="tab"
                                href="#YTM4ZDU4MTgtNTIwMS00OThiLTg2YjMtNDZjN2ExY2FhY2Nh0" role="tab"
                                data-type="Account Information" aria-selected="true">
                                Account Information
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content w-100">
                    <div class="tab-pane fade active show" id="YTM4ZDU4MTgtNTIwMS00OThiLTg2YjMtNDZjN2ExY2FhY2Nh0"
                        role="tabpanel" aria-labelledby="Account Information">
                        <div class="container-fluid px-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-content">
                                        <h4 class="navbar navbar-light mt-3 pl-0">Account Information</h4>
                                        <div class="row pl-0">
                                            <div class="col-md-6 pt-2">
                                                <label>Account Owner :
                                                    <span>{{ $entry->OwnerFormat }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Rating : <span>{{ $entry->RatingFormat }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Account Name : {{ $entry->name }} </label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Phone : <a href="tel:{{ $entry->phone }}"
                                                        class="text-primary">{{ $entry->phone }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Parent Account : {{ $entry->ParentFormat }}</label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Fax : <span>{{ $entry->fax }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Account Number :
                                                    <span>{{ $entry->account_number }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Account Site : <a href="" target="_blank" class="text-primary"></a>
                                                    {{ $entry->website }}
                                                </label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Ticker Symbol : <span>{{ $entry->ticker_symbol }}</span></label>
                                            </div>
                                            {{-- <div class="col-md-6 pt-2">
                                                <label> Type : <span>Business</span></label>
                                            </div> --}}
                                            <div class="col-md-6 pt-2">
                                                <label> Ownership :
                                                    <span>{{ $entry->OwnershipFormat }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Industry :
                                                    <span>{{ $entry->IndustryFormat }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Number Of Employees :
                                                    <span>{{ $entry->number_of_employees }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Annual Revenue :
                                                    <span>{{ $entry->annual_revenur }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> SIC Code : <span>{{ $entry->sic }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Bank branch : <span>{{ $entry->bank_branch }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Billing Address :
                                                    <span>{{ $entry->billing_address }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                               <label>Email :<a href="mailto:{{ $entry->email }}">  <span>{{ $entry->email }}</span></a></label> 
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Address :
                                                    <span>{{ $entry->AddressFormat }}</span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Valid Until : <span>{{ $entry->valid_until }}</span></label>
                                            </div>
                                        </div>
                                        <h4 class="navbar navbar-light mt-3 pl-0">Description:</h4>
                                        <p class="text-dark text-break">{!! $entry->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/mycss.css').'?v='. time() }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/crud.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/show.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script src="{{ asset('packages/backpack/crud/js/show.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
@endsection