@extends('backpack::blank')

@section('header')
    <section class="container-fluid d-print-none">
        <div class="row float-right mr-2">
            @if (!$entry->user_id && $entry->type == 'Business')
                <a href="#/" class="btn btn-sm btn-warning btn-custom"
                    class="btn btn-sm btn-warning btn-custom"
                    id="macf-call-modal-request-property-listing"
                    data-entry=''
                    data-action-form="update"
                >
                Conver to user</a>
            @endif
            <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="btn btn-sm btn-info mr-2"><i class="la la-edit"></i></a>
            <a href="javascript: window.print();" class="btn btn-sm btn-default"><i class="la la-print"></i></a>
        </div>

        @component('backpack.global_modal.modal_ajax', [
            'title' => 'Conver To User',
            'btnIdentify' => 'updatePropertyListion',
            'modalType' => 'lg',
            'btn_label' => 'Convert',
            'btn_icon' => '',
            'btn_class' => 'btn btn-success btn-custom',
            'action_form' => 'update',
            'labelButtonUpdate' => 'Convert',
            'route' => route('user.convertUser'),
            'view' => view('backpack.contacts.form_conver_user', ['crud' => $crud, 'entry' => $entry])
        ])
        @slot('formData')
            formData.append("id", '{{ $entry->id }}')
            formData.append("FullName", '{{ $entry->FullName }}')
            formData.append("email", '{{ $entry->email }}')
            formData.append("phone", '{{ $entry->phone }}')
            formData.append("profile", '{{ $entry->profile }}')
            formData.append("user_id", '{{ $entry->user_id_fk }}')
        @endslot

        @slot('loadEntry')
        @endslot
            
        @slot('axiosThen')
            {{-- this.setDataEntry(this.result) --}}
            this.toggleModal('close')
            setTimeout(function(){
                window.location.reload();
            }, 500);
        @endslot
        @endcomponent
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="box box-box box-primary" style="max-width: 18rem">
            <h5 class="card-header bg-gray">User Information</h5>

            <div class="card-img-top">
                @if (!($entry->profile))
                    <img src="{{ asset('uploads/profile/R.png') }}" alt="" class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                @else
                    <img src="{{ asset($entry->profile) }}" alt="" class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                @endif
            </div>
            <div class="text-center">
                <h3 class="profile-username text-center text-capitalize text-break">{{ $entry->FullName }}</h3>
                <a href="" class="text-decoration-none" target="_blank">
                    <span class="text-muted"><em class="la la-bank"></em></span>
                </a>
            </div>
            <div class="card-body">
                <ul class="list-group pb-2">
                    <li class="list-group-item border-left-0 border-right-0">
                        <em class="nav-icon la la-phone mr-1"></em>
                        <a href="tel:">{{ $entry->phone }}</a>
                    </li>
                    <li class="list-group-item border-left-0 border-right-0">
                        <em class="nav-icon la la-envelope mr-1"></em><a href="mailto:" class="text-break">{{ $entry->email }}</a>
                    </li>
                    <li class="list-group-item border-left-0 border-right-0">
                        <strong><em class="la la-map-marker margin-r-5"></em></strong>
                        <span class="text-dark text-break">{{ optional($entry->addressEntity)->_path_kh }}</span>
                    </li>
                </ul>
                <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="btn btn-primary btn-block">
                    <strong>Edit Profile</strong>
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="mnb-custom d-flex flex-wrap w-100 mb-3 bg-white">
                <div class="d-flex justify-content-between flex-wrap w-100">
                    <ul class="nav" role="tabTitle">
                        <a class="nav-link" style="cursor: pointer">
                            <i class="la la-home"></i>
                            Information
                        </a>
                    </ul>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change active" data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz10" role="tab" data-type="My Profile">My Profile</a>
                        </li>
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz11" role="tab" data-type="My Tasks">
                            My Tasks
                            </a>
                        </li>
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz12" role="tab" data-type="Leads">
                            Leads
                            </a>
                        </li>
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz13" role="tab" data-type="Owner Property">
                            Owner Property
                            </a>
                        </li>
                            <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz14" role="tab" data-type="Property">
                            Property
                            </a>
                        </li>
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz15" role="tab" data-type="Listing">
                            Listing
                            </a>
                        </li>
                        <li class="nav-item" role="tablist">
                            <a class="nav-link btn-tab-change " data-toggle="tab" href="#Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz16" role="tab" data-type="Indication Plus">
                            Indication Plus
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz10" role="tabpanel" aria-labelledby="My Profile">
                        <div class="container-fluid px-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-content">
                                        <h4 class="navbar bg-light navbar-light mt-3 pl-0">Contact Information</h4>
                                        <div class="row pl-0">
                                            <div class="col-md-6 pt-2">
                                                <label>Contact Owner :<a class="text-primary">{{ optional($entry->contactOwnerEntity)->FullName }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Full Name : <span><a href="" class="text-primary">{{ $entry->FullName }}</a></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Contact Type : <a class="text-primary">{{ $entry->type }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Mobile Phone : <a href="tel:{{ $entry->phone }}" class="text-primary">{{ $entry->phone }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Business Phone : <a href="" class="text-primary">{{ $entry->phone_2 }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Other Phone : <a href="" class="text-primary">{{ $entry->phone_3 }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label> Email : <a href="mailto:" class="text-primary">{{ $entry->email }}</a></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Department : <span><a href="mailto:" class="text-primary">{{ $entry->department }}</a></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Fax : <span><a href="" class="text-primary">{{ $entry->fax }}</a></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Reports To :
                                                {{-- <a href="" class="text-primary" target="_blank">{{ $entry->reportToEntity->UserFullName }}</a> --}}
                                                </label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Assistant Name : <span><a href="" class="text-primary">{{ $entry->assistant_name }}</a></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Lead Source : <span><a href="" class="text-primary">{{ $entry->lead_source }}</a></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Region : <span></span></label>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <label>Assistant Phone : <a href="" class="text-primary">{{ $entry->phone_4 }}</a></label>
                                            </div>
                                        </div>
                                        <h4 class="navbar bg-light navbar-light mt-3 pl-0">Personal Information</h4>
                                        <div class="row pl-0">
                                            <div class="col-md-6 pt-2">
                                                <span>Working Field : </span>
                                                <span><a href="" class="text-primary">{{ $entry->working_field }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Position/Occupation : </span>
                                                <span><a href="" class="text-primary">{{ $entry->occupation }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Relationships : </span>
                                                <span><a href="" class="text-primary">{{ $entry->Relationships }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Identity Card Number : </span>
                                                <span><a href="" class="text-primary">{{ $entry->identity_card }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Date of Birth : </span>
                                                <span><a href="" class="text-primary">{{ $entry->date_of_birth }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Remark : </span>
                                                <span><a href="" class="text-primary">{{ $entry->remark }}</a></span>
                                            </div>
                                            <div class="col-md-6 pt-2">
                                                <span>Identity card photos : </span>
                                                <div class="row">
                                                    <div id="small-img" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center">
                                                    @if(!($entry->identity_card_photos))
                                                        <img src="" alt="" class="">
                                                    @else
                                                        {{-- <img src="{{asset($entry->identity_card_photos)}}" alt="..." class=""> --}}
                                                        @foreach ($entry->identity_card_photos as $image)
                                                            <img src="{{asset($image)}}" style="width:150px; height:150px;"/>
                                                        @endforeach
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="navbar bg-light navbar-light mt-3 pl-0">Description Information</h4>
                                        <div class="row pl-0">
                                            <div class="col-md-12 pt-2">
                                                <p>{{ $entry->description}}</p>
                                            </div>
                                        </div>
                                        <h4 class="navbar bg-light navbar-light mt-3 pl-0">Address</h4>
                                        <div class="row pl-0">
                                            <div class="col-md-12">
                                                <span>Current Address : </span>
                                                <span class="text-dark text-break">{{ optional($entry->addressEntity)->_path_en }}</span>
                                            </div>
                                        </div>
                                        <div class="row pl-0">
                                            <div class="col-md-6">
                                                <label>Created By : <span>{{ optional($entry->ContactsCreatedName)->FullName}}</span></label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Updated By : <span>{{ optional($entry->ContactsUpdatedName)->FullName}}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Yomn4XmrY6wDSLiVc9GueILNNUfiodMEzQeP39Uz11" role="tabpanel" aria-labelledby="My Tasks">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Task Activities</h3>
                            </div>
                            <div class="box-body">
                                <div class="content-right-wrapper">
                                    <div class="container pl-0">
                                        <div class="row">
                                            <div class="col-md-12 pr-0">
                                                <div class="mx-0">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive">
                                                                <table class="table border" id="contact_task_activity_table" aria-labelledby="activity">
                                                                    <thead class="bg-light">
                                                                        <tr class="text-primary">
                                                                            <th scope="col" width="20%" class="align-top text-nowrap">Title</th>
                                                                            <th scope="col" width="25%" class="align-top text-nowrap">Priority </th>
																		    <th scope="col" width="14%" class="align-top text-nowrap">Task Owner</th>
																		    <th scope="col" width="16%" class="align-top text-nowrap">Due Date</th>
																		    <th scope="col" width="16%" class="align-top text-nowrap">Associate To</th>
																		    <th scope="col" width="7%" class="align-top text-nowrap"></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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