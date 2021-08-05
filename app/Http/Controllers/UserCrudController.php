<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\ContactRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ShowOperation;

    protected $contactRepo;
    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));
        $this->crud->setShowView('Admin.Users.show');
        $this->contactRepo = resolve(ContactRepository::class);
    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'text',
            ],
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'phone',
                'label' => trans('Phone Number'),
                'type'  => 'phone',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
            ],
        ]);

        // Role Filter
        // $this->crud->addFilter(
        //     [
        //         'name'  => 'role',
        //         'type'  => 'dropdown',
        //         'label' => trans('backpack::permissionmanager.role'),
        //     ],
        //     config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
        //     function ($value) { // if the filter is active
        //         $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
        //             $query->where('role_id', '=', $value);
        //         });
        //     }
        // );

        // // Extra Permission Filter
        // $this->crud->addFilter(
        //     [
        //         'name'  => 'permissions',
        //         'type'  => 'select2',
        //         'label' => trans('backpack::permissionmanager.extra_permissions'),
        //     ],
        //     config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
        //     function ($value) { // if the filter is active
        //         $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
        //             $query->where('permission_id', '=', $value);
        //         });
        //     }
        // );
    }

    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $fullname = request()->Salutation. " ".request()->FirstName." ".request()->LastName;
        $response = $this->traitStore();
        $this->contactRepo->createContact($this->crud->entry, request());
        User::find($this->crud->entry->id)->update([
            'name' => $fullname
        ]);

        return $response;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        $full_name = request()->Salutation . " " . request()->FirstName . " " . request()->LastName;
        $response = $this->traitUpdate();

        $this->contactRepo->updateContact($this->crud->entry, request());
        User::find($this->crud->entry->id)->update([
            'name' => $full_name,
        ]);
        return $response;
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields()
    {
        $colMd6 = ['class' => 'form-group col-md-6'];
        $this->crud->addFields([
            [
                'name' => 'Salutation',
                'type' => 'select2_from_array',
                'allows_null' => true,
                'label' => 'Salutation',
                'options' => ['Mr' => 'Mr', 'Ms' => 'Ms.', 'Mrs' => 'Mrs.', 'Oknha' => 'Oknha', 'H.E' => 'H.E', 'Dr' => 'Dr.', 'Neak Oknha' => 'Neak Oknha', 'Dato' => 'Dato'],
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'FirstName',
                'label' => 'FirstName',
                'type'  => 'text',
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'LastName',
                'label' => 'LastName',
                'type'  => 'text',
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'phone',
                'label' => 'Phone number',
                'type' => 'flexi.phone',
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'is_phone_verified',
                'label' => 'Verified phone',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                ],
                'allows_null' => true,
                'default' => Carbon::now(),
                'wrapper' => $colMd6
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
            ],
            [
                // Custom Field From Contact
                'label' => 'Profile',
                'name' => "ProfileUser",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            ],
            [
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }
}
