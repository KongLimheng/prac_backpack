<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LeadsRequest;
use App\Repositories\OptionRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LeadsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LeadsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitstore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitupdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    protected $optRepo;
    public function setup()
    {
        CRUD::setModel(\App\Models\Leads::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/leads');
        CRUD::setEntityNameStrings('leads', 'leads');
        $this->optRepo = resolve(OptionRepository::class);
        $this->opt = collect($this->optRepo->getTypesByParentIDs([3], false))->groupBy('parent_id');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'type' => 'text',
                'label' => 'Lead ID',
                'name' => 'id',
                'prefix' => '00'
            ],
            [
                'type' => 'text',
                'label' => 'Name',
                'name' => 'FullName',
            ],
            [
                'type' => 'phone',
                'label' => 'Mobile Phone',
                'name' => 'phone',
            ],
            [
                'type' => 'text',
                'label' => 'Lead Type',
                'name' => 'lead_type',
            ],
            [
                'type' => 'text',
                'label' => 'Created_by',
                'name' => 'leadCreatedName',
                'attribute' => 'UserName'
            ],
            [
                'type' => 'text',
                'label' => 'Date/Time Created',
                'name' => 'created_at',
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
        CRUD::setValidation(LeadsRequest::class);

        $this->crud->addFields([
            [
                'name'  => 'lead-info',
                'type'  => 'custom_html',
                'value' => '<nav class="navbar navbar-light bg-light"><span class="navbar-brand mb-0 h4">Contact Information</span></nav>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12'],                
            ],
            [
                'label' => 'Salutation',
                'name' => 'salutation',
                'type'        => 'select2_from_array',
                'options'     => ['Mr.' => 'Mr.', 'Ms.' => 'Ms.', 'Mrs.' => 'Mrs.', 'Oknha' => 'Oknha', 'H.E' => 'H.E', 'Dr' => 'Dr', 'Dato' => 'Dato'],
                'allows_null' => true,
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Lead Owner',
                'name' => 'owner',
                'entity' => 'ownerLead',
                'type'        => 'select2_from_ajax',
                'attribute' => 'FullName',
                'placeholder' => "Lead owner",
                'data_source' => url('api/contact'),
                'minimum_input_length'    => 0,
                'default' => optional(backpack_user()->contact)->id,
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'First Name',
                'name' => 'first_name',
                'type'        => 'text',
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Last Name',
                'name' => 'last_name',
                'type'        => 'text',
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Lead Type',
                'name' => 'lead_type',
                'type'        => 'select2_from_array',
                'options' => ['240' => 'Referral-Inquiry', '241' => 'Referral-Listing'],
                'allows_null'=> true,
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Industry',
                'name' => 'industry',
                'type'        => 'select2_from_array',
                'options' => $this->opt[3]->pluck('value', 'value'),
                'wrapperAttributes' => $colMd6
            ],
            [
                'name'  => 'contact-info',
                'type'  => 'custom_html',
                'value' => '<nav class="navbar navbar-light bg-light"><span class="navbar-brand mb-0 h4">Contact Information</span></nav>',
                'wrapperAttributes' => ['class' => 'form-group col-md-12'],                
            ],
            [
                'label' => 'Mobile Phone',
                'name' => 'phone',
                'type'        => 'flexi.phone',
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Email',
                'name' => 'email',
                'type'        => 'email',
                'wrapperAttributes' => $colMd6
            ],
            [
                'label' => 'Business Phone',
                'name' => 'business_phone',
                'type'        => 'flexi.phone',
                'wrapperAttributes' => $colMd6
            ],

        ]);
        
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
        $this->crud->setOperationSetting('contentClass', 'col-md-12');
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
        $userId = backpack_user()->id;
        // $contactId = DB::table('contacts')->where('user_id_fk', $userId)->first();
        // debugbar()->info($contactId);
        request()->merge([
            'created_by' => $userId
        ]);
        
        $this->crud->addField(['type' => 'hidden', 'name'=> 'created_by']);
        return $this->traitstore();
    }

}
