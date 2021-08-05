<div class="col-md-3 ">
    <div class="box box-box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                User Information
            </h3>
            <div class="box-tools pull-right">
                <button type="button"
                    class="btn btn-box-tool"
                    data-widget="collapse"><i class="la la-minus"></i>
                </button>
                <button type="button"
                    class="btn btn-box-tool"
                    data-widget="remove"><i class="la la-times"></i></button>
            </div>
        </div>

        <div class="box-body">
            <div class="box-body box-profile p-0">
                <div class="border-box text-center pb-2">   
                    @if (!$entry->contact->profile)
                        <img src="{{ asset('img\default-user.png') }}"
                            alt="..."
                            class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                    @else
                        <img src="{{ asset('/') . optional($entry->contact)->profile }}"
                            alt="..."
                            class="profile-user-img img-responsive img-fluid d-block mx-auto rounded-circle img-thumbnail">
                    @endif
                </div>
                <div class="text-center">
                    <h3 class="profile-username text-center text-capitalize text-break">{{ $entry->name }}</h3>
                </div>

                <ul class="list-group pb-2">
                    <li class="list-group-item border-left-0 border-right-0">
                        <em class="nav-icon la la-phone mr-1"></em>
                        <a href="">{{ $entry->phone }}</a>
                    </li>
                    <li class="list-group-item border-left-0 border-right-0">
                        <em class="nav-icon la la-envelope mr-1"></em>
                        <a href="mailto:"
                            class="text-break">{{ $entry->email }}</a>
                    </li>
                </ul>
                <a href="{{ url($crud->route . '/' . $entry->getKey() . '/edit') }}"
                    class="btn btn-primary btn-block"><strong>Edit Profile</strong></a>
            </div>
        </div>
    </div>
</div>
