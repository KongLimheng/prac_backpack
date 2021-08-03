@extends('backpack::blank')

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.add') => false,
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>{{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getCreateContentClass() }}">
            @include('crud::inc.grouped_errors')
        
            <form action="{{ url($crud->route) }}" method="post" 
                @if ($crud->hasUploadFields('create'))
                    enctype="multipart/form-data"
                @endif>
                @csrf
            
                @if (view()->exists('vendor.backpack.crud.form_content'))
                    @include('vendor.backpack.crud.form_content', ['fields' =>$crud->fields(), 'action' => 'create'])
                @else
                    @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'create'])
                @endif

                @include('crud::inc.form_save_buttons')
            </form>
        </div>
    </div>

    @include('backpack.contacts.contact_script')
    @include('backpack.contacts.add_require_script')
@endsection