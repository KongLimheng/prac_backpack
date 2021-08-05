<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContactsRequest;
use App\Models\Account;
use App\Repositories\OptionRepository;
use App\Traits\GetUserLoginTrait;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

/**
 * Class ContactsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use GetUserLoginTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    protected $options;

    public function setup()
    {
        CRUD::setModel(\App\Models\Contacts::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contacts');
        CRUD::setEntityNameStrings('contacts', 'contacts');
        $this->crud->setCreateView('backpack.contacts.create');
        $this->crud->setShowView('backpack.contacts.show');
        $this->crud->setEditView('backpack.contacts.edit');

        $this->crud->denyAccess(['create', 'delete','show','update']);
        if(backpack_user()->hasRole('dev')){
            $this->crud->allowAccess(['list','show', 'create', 'delete','update']);
        }
        // if(backpack_user()->hasPermissionTo('contact create')){
        //     $this->crud->allowAccess('create');
        // }

    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        
        CRUD::addColumn(['name' => 'id', 'label' => 'ID', 'prefix' => '000']);
        $this->crud->addColumns([
            [
                'name' => 'FullName',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name'     => 'phone', // The db column name
                'label'    => 'Phone number', // Table column heading
                'type'     => 'phone',
                // 'orderable' => true,
                'serchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('phone', 'like', '%' . $searchTerm . '%');
                }
            ],
            [
                'name' => 'user_id_fk',
                'label' => 'USER',
                'type' => 'check',
            ],
            [
                'name' => 'contactOwnerEntity',
                'label' => trans('Contact Owner'),
                'type' => "select",
                'attribute' => "FullName",
                // 'searchLogic' => function ($query, $column, $searchTerm) {
                //     $query->orWhereHas('contactOwnerEntity', function ($q) use ($column, $searchTerm) {
                //         $q->SearchText($searchTerm);
                //     });
                // }
            ],
            // [
            //     'label'          => 'Account Name', // Table column heading
            //     'type'           => 'select',
            //     'name'           => 'account_id', // the column that contains the ID of that connected entity;
            //     'entity'         => 'accountNameEntity', // the method that defines the relationship in your Model
            //     'attribute'      => 'name'
            // ],
            [
                'name' => 'lead_source',
                'label' => 'Ref Resource',
                'type' => 'text',
                'searchLogic' => function ($query, $column,  $searchTerm) {
                    $query->orWhere(function ($q) use ($searchTerm) {
                        $q->SearchText($searchTerm);
                    });
                }
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'text',
                'searchLogic' => function ($query, $column,  $searchTerm) {
                    $query->orWhere(function ($q) use ($searchTerm) {
                        $q->SearchText($searchTerm);
                    });
                }
            ],
            [
                'name'  => 'ContactsCreatedName', // The db column name
                'label' => 'Created By', // Table column heading
                'type'  => 'select',
                'attribute' => 'FullName'
            ],
            [
                'name'  => 'created_at', // The db column name
                'label' => 'Created At', // Table column heading
                'type'  => 'date'
            ]
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $colMd6 = ['class' => 'form-group col-md-6'];
        $this->crud->setValidation(ContactsRequest::class);

        // info tab
        CRUD::addFields([
            [
                'label'     => "Account Owner",
                'type'      => 'select2_from_ajax',
                'name'      => 'owner',
                'entity'    => 'contactOwnerEntity', // the method that defines the relationship in your Model
                'attribute' => 'FullName',
                'data_source' => url('api/contact'),
                'default' => optional(backpack_user()->contact)->id,
                'placeholder'             => "contact owner",
                'minimum_input_length'    => 0,
                'wrapperAttributes' => $colMd6,
                'tab' => 'Contact Info'
            ],
            [
                'name'        => 'salutation',
                'label'       => "Salutation",
                'type'        => 'select2_from_array',
                'options'     => ['Mr.' => 'Mr.', 'Ms.' => 'Ms.', 'Mrs.' => 'Mrs.', 'Oknha' => 'Oknha', 'H.E' => 'H.E', 'Dr' => 'Dr', 'Dato' => 'Dato'],
                'allows_null' => true,
                'tab'   => 'Contact Info',
                'wrapperAttributes' => $colMd6
            ],
            [ // Text
                'name'  => 'first_name',
                'label' => 'First Name',
                'type'  => 'text',

                'tab'   => 'Contact Info',
                'wrapperAttributes' => $colMd6,
            ],
            [ // Text
                'name'  => 'last_name',
                'label' => 'Last Name',
                'type'  => 'text',
                'wrapperAttributes' => $colMd6,
                'tab'   => 'Contact Info',
            ],
            [
                'name'        => 'type',
                'label'       => "Type",
                'type'        => 'select2_from_array',
                'options'     => ['Personal' => 'Personal', 'Business' => 'Business'],
                'allows_null' => false,
                'default'     => 'Personal',
                'tab'   => 'Contact Info',
                'wrapperAttributes' => $colMd6
            ],
            [
                'name'        => 'address_account',
                'label'       => 'Address Account <span style="color: red;">*</span>',
                'type'        => 'select2_from_array',
                'options'     => [
                    'Chamkar Mon' => 'Chamkar Mon',
                    'Doun Penh' => 'Doun Penh',
                    'Prampir Meakkakra' => 'Prampir Meakkakra',
                    'Tuol Kouk' => 'Tuol Kouk',
                    'Dangkao' => 'Dangkao',
                    'Mean Chey' => 'Mean Chey',
                    'Russey Keo' => 'Russey Keo',
                    'Saensokh' => 'Saensokh',
                    'Pur SenChey' => 'Pur SenChey',
                    'Praek Pnov' => 'Praek Pnov',
                    'Chraoy Chongvar' => 'Chraoy Chongvar',
                    'Chbar Ampov' => 'Chbar Ampov',
                    'Boeng Keng Kang' => 'Boeng Keng Kang',
                    'Kamboul' => 'Kamboul',
                    'Banteay Meanchey' => 'Banteay Meanchey',
                    'Kampong Cham' => 'Kampong Cham',
                    'Kampong Chhnang' => 'Kampong Chhnang',
                    'Kampong Speu' => 'Kampong Speu',
                    'Kampong Thom' => 'Kampong Thom',
                    'Kampot' => 'Kampot',
                    'Kandal' => 'Kandal',
                    'Koh Kong' => 'Koh Kong',
                    'Kratie' => 'Kratie',
                    'Mondul Kiri' => 'Mondul Kiri',
                    'Preah Vihear' => 'Preah Vihear',
                    'Prey Veng' => 'Prey Veng',
                    'Pursat' => 'Pursat',
                    'Ratanak Kiri' => 'Ratanak Kiri',
                    'Siemreap' => 'Siemreap',
                    'Preah Sihanouk' => 'Preah Sihanouk',
                    'Stung Treng' => 'Stung Treng',
                    'Svay Rieng' => 'Svay Rieng',
                    'Takeo' => 'Takeo',
                    'Oddar Meanchey' => 'Oddar Meanchey',
                    'Kep' => 'Kep',
                    'Pailin' => 'Pailin',
                    'Tboung Khmum' => 'Tboung Khmum'
                ],
                'allows_null' => true,

                'tab'   => 'Contact Info',
                // 'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6', 'id' => 'address_account'],
            ],
            [   // 1-n relationship
                'label'       => "Account Name", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'account_id', // the column that contains the ID of that connected entity
                'entity'      => 'accountNameEntity', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => url("api/account"), // url to controller search function (with /{id} should return model)
                // 'default'     => backpack_auth()->user()->id,
                // OPTIONAL
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "select account name", // placeholder for the select
                'minimum_input_length'    => 0, // minimum characters to type before querying results
                // 'model'                   => "App\Models\Category", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                // 'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                // 'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
                'allows_null' => true,
                'default'     => '',
                'tab'   => 'Contact Info',
                'wrapperAttributes' => ['class' => 'form-group col-md-6 d-none', 'id' => 'account_id',],
            ],
            [ // Phone
                'name'  => 'phone',
                'label' => 'Phone Number',
                'type'  => 'flexi.phone',
                'tab'   => 'Contact Info',
                'wrapperAttributes' => $colMd6,
            ],
            [ // Text
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
                'tab'   => 'Contact Info',
                'wrapperAttributes' => $colMd6
            ],
            // [
            //     'label' => "Region",
            //     'name' => "khaddress",
            //     'type' => 'select2_multiple',
            //     'entity'      => 'AddressCity', // the method that defines the relationship in your Model
            //     'attribute'   => "_name_en", // foreign key attribute that is shown to user
            //     'model' => 'App\Models\Address',
            //     // 'value' => '_code',
            //     'pivot'     => true,
            //     'select_all' => true, 
            //     'tab' => 'Contact Info',
            //     'wrapper' => $colMd6
            // ],
        ]);
        // CRUD::addField([
        //     // Select2Multiple = n-n relationship (with pivot table)
        //     'label' => trans('flexi.region'),
        //     'type' => 'select2_multiple',
        //     'name' => 'khAddresses', // the method that defines the relationship in your Model
        //     'allows_null' => false,
            
        //     // optional
        //     'model' => KhAddress::class, // foreign key model
        //     'attribute' => '_name_en', // foreign key attribute that is shown to user
        //     'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        //     'select_all' => true, // show Select All and Clear buttons?
        //     'value' => $entryAddress,
        //     'options' => (function ($query) use($address){
        //     return $query->whereIn('_code',$address)
        //     ->orderBy('_code', 'ASC')->get();
        //     }),
        //     // optional
        //     'wrapper' => [
        //     'class' => 'form-group col-md-6'
        //     ],
        //     'tab' => $tabShort
        //     ]);

        // other tab
        $this->crud->addFields([
            [ // Text
                'name'  => 'phone_2',
                'label' => 'Business Phone',
                'type'  => 'flexi.phone',
                'placeholder' => 'Mobile Phone',

                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [ // Text
                'name'  => 'phone_3',
                'label' => 'Other Phone',
                'type'  => 'flexi.phone',

                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [   // Text
                'name'  => 'title',
                'label' => "Title",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [   // Text
                'name'  => 'fax',
                'label' => "Fax",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [   // Text
                'name'  => 'deprtement',
                'label' => "Departement",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [   // Text
                'name'  => 'assistan_name',
                'label' => "Assistant Name",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [ // Text
                'name'  => 'phone_4',
                'label' => 'Assistant Phone',
                'type'  => 'flexi.phone',

                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [
                'name'        => 'lead_source',
                'label'       => "Lead Source",
                'type'        => 'select2_from_array',
                'options'     => [
                    'Z1 App' => 'Z1 App',
                    'Z1 Web' => 'Z1 Web',
                    'Signboard' => 'Signboard',
                    'Facebook' => 'Facebook',
                    'Other' => 'Other'
                ],
                'allows_null' => true,

                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [
                'name' => 'is_vip',
                'label' => 'VIP Contact',
                'type' => 'flexi.checkbox_button',
                'tab'   => 'Other',
                'wrapper' => 'form-group col-md-12 is_vip',
            ],
            [
                'name'  => 'heading-personal-info',
                'type'  => 'custom_html',
                'value' => '<h3 class="navbar-brand mb-0 h3">Personal Information</h3>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12 bg-light'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'working_field',
                'label' => 'Working Field <span></span>',
                'type' => 'select2_from_array',
                'options' => ['Advertising and Media/Entertainment' => 'Advertising and Media/Entertainment', 'Airline' => 'Airline', 'Construction' => 'Construction', 'Consulting Service' => 'Consulting Service', 'Education' => 'Education', 'IT' => 'IT', 'Doctor' => 'Doctor'],
                'allows_null' => 'true',
                'wrapperAttributes' => ['class' => 'form-group col-md-6 vipRequired', 'id' => 'working_field'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'occupation',
                'label' => 'Position/Occupation <span></span>',
                'type' => 'select2_from_array',
                'options' => ['Digital Maketing' => 'Digital Maketing', 'Nurse' => 'Nurse'],
                'allows_null' => 'true',
                'wrapperAttributes' => ['class' => 'form-group col-md-6 vipRequired', 'id' => 'occupation'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'relationships',
                'label' => 'Relationship <span></span>',
                'type' => 'select2_from_array',
                'options' => ['Friend' =>'Friend', 'Relative' => "Relative", 'New Client' => 'New Client', 'Existing Client' => 'Existing Client'],
                'allows_null' => true,
                'wrapperAttributes' => ['class' => 'form-group col-md-6 vipRequired', 'id' => 'relationships'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'identity_card',
                'label' => 'Identity Card Name',
                'type' => 'text',
                'wrapperAttributes' => $colMd6,
                'tab'   => 'Other',
            ],
            [   // Date
                'name'  => 'date_of_birth',
                'label' => 'Date of Birth',
                'type' => 'date_picker',
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'dd/mm/yyyy',
                    'language' => 'en'
                 ],
                'wrapperAttributes' => $colMd6,
                'tab'   => 'Other',
            ],
            [   // Text
                'name'  => 'remark',
                'label' => "Remark",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [
                'name' => 'identity_card_photos',
                'label' => 'Identity card photos (Each photo is limited within 2MB.)',
                'type' => 'flexi.upload_uppy_multi',
                // 'upload'    => true,
                // 'disk'      => 'uploads', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
                // // optional:
                // 'temporary' => 10, // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified

                'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                'tab'   => 'Other',
            ],
            [
                'name'  => 'heading-address',
                'type'  => 'custom_html',
                'value' => '<h3 class="navbar-brand mb-0 h3">Address</h3>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12 bg-light'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'address',
                'label' => 'address',
                'type' => 'flexi.address',
                'wrapperAttributes' => $colMd6,
                'tab' => 'Other'
                // 'setRequired' => 8
            ],
            [   // Text
                'name'  => 'house_no',
                'label' => "House (№)",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [   // Text
                'name'  => 'street_no',
                'label' => "Street (№)/Name",
                'type'  => 'text',
                'tab'   => 'Other',
                'wrapperAttributes' => $colMd6,
            ],
            [
                'name'  => 'heading-desc-info',
                'type'  => 'custom_html',
                'value' => '<h3 class="navbar-brand mb-0 h3">Description Information</h3>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                'tab'   => 'Other',
            ],
            [
                'name' => 'description',
                'type' => 'summernote',
                'tab'   => 'Other',

            ],
        ]);
        $this->crud->setOperationSetting('contentClass', 'col-md-12 bold-labels');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function store()
    {
        $userId = backpack_auth()->user()->id;
        $contactId = DB::table('contacts')->where('user_id_fk', $userId)->first();
        // debugbar()->info($contactId);
        request()->merge([
            'created_by' => $contactId->id
        ]);
        $this->crud->addField(['type' => 'hidden', 'name'=> 'created_by']);

        $res = $this->traitStore();
        return $res;
    }

    public function update()
    {
        $userId = backpack_user()->id;
        $contactId = DB::table('contacts')->where('user_id_fk', $userId)->first(['id']);
        request()->merge([
            'updated_by' => $contactId->id
        ]);
       
        $this->crud->addField(['type'=> 'hidden', 'name'=> 'updated_by']);

        $res = $this->traitUpdate();
        return $res;

    }

    public function fetchContact()
    {
        $search_term = request()->q;

            if ($search_term)
            {
                $results = $this->crud->model->where('first_name', 'iLIKE', '%'.$search_term.'%')
                ->orWhere('last_name', 'iLIKE', '%'.$search_term.'%');
            }
            else
            {
                $results = $this->crud->model;
            }

            // return $results;
        return ['data' => $results
            ->paginate(10)
            ->map(function ($v) {
            return [
                'id' => $v->id,
                'FullName' => $v->fullName
                ];
            })
        ];
    }
}
