<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccountRequest;
use App\Repositories\OptionRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AccountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AccountCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    protected $optionRepository;

    protected function setupReorderOpteration()
    {
        $this->crud->set('reorder.label', 'name');
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $keys = [
            3, // Account Industry
            4, // Listing Api Location
            5, // Lead Rating
            6, // Account Ownership
        ];
        CRUD::setModel(\App\Models\Account::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/account');
        CRUD::setEntityNameStrings('account', 'accounts');
        $this->crud->setShowView('backpack.accounts.show');
        $this->crud->allowAccess('reorder');
        $this->crud->orderBy('lft');

        $this->optionRepository = resolve(OptionRepository::class);
        $this->options = collect($this->optionRepository->getTypesByParentIDs($keys, false))->groupBy('parent_id');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->enableResponsiveTable();
        $this->crud->addColumns([
            [
                'name'      => 'id',
                'label'     => 'Account ID',
                'type'      => 'number',
                'prefix'    => '000',
            ],
            [
                'name'      => 'logo',
                'label'     => 'Logo',
                'type'      => 'closure',
                'function'  => function ($entry) {
                    if ($entry->logo) {
                        return '<a class="example-image-link" href="' . asset($entry->logo) . '" data-lightbox="lightbox-' . $entry->id . '">
                                    <img class="img-fluid img-thumbnail" src="' . asset($entry->logo) . '" alt="" width="80" style="cursor:pointer"/>
                                </a>';
                    } else {
                        return '<a class="example-image-link" href="' . asset('uploads/profile/R.png') . '" data-lightbox="lightbox-' . $entry->id . '">
                                    <img class="img-fluid img-thumbnail" src="' . asset('uploads/profile/R.png') . '" alt="" width="80" style="cursor:pointer"/>
                                </a>';
                    }
                }
            ],
            [
                'name'      => 'name',
                'label'     => "Account Name",
                'type'      => 'text'
            ],
            [
                'label'     => "Account Number",
                'name'      => 'account_number',
                'type'      => 'text',
            ],
            [
                'label'     => 'Account Site',
                'name'      => 'website',
                'type'      => 'text',
            ],
            [
                'name'      => 'phone',
                'label'     => 'Phone',
                'type'      => 'text',
            ],
            [
                'label'     => 'Acount Owner',
                'type'      => 'text',
                'name'      => 'OwnerFormat',
                // 'entity'    => 'owners', 
                // 'attribute' => 'name', 
                // 'model'     => "App\Models\User", 
            ],
            [
                'label'     => 'Bank Branch',
                'name'      => 'bank_branch',
                'type'      => 'text',
            ],
            // [
            //     'label'     => 'Created By', 
            //     'type'      => 'text',
            //     'name'      => 'CreateByFormat', 
            //     // 'entity'    => 'owners', 
            //     // 'attribute' => 'name', 
            //     // 'model'     => "App\Models\User", 
            //  ],
            [
                'label'     => 'Created At',
                'name'      => 'created_at',
                'type'      => 'date',
            ],
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
        CRUD::setValidation(AccountRequest::class);
        // debugbar()->info($this->options[4]->pluck('value', 'value'));

        $this->crud->addFields([
            [
                'label'     => 'Account owner',
                'name'      => 'ownerAcc',
                'type'      => 'relationship',
                'attribute' => "FullName",
                'ajax'      => true,
                'minimum_input_length' => -1, // -1: click to load data without waiting search
                'data_source' => url("api/contact"),
                // 'placeholder' => trans('select_a_account'),
                'default' => backpack_user()->contact->id,
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Account Name",
                'type'                  => 'text',
                'name'                  => 'name',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Alias",
                'type'                  => 'text',
                'name'                  => 'alias',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Bank Branch",
                'type'                  => 'text',
                'name'                  => 'bank_branch',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'phone',
                'label'                 => 'Normal Phone',
                'type'                  => 'flexi.phone',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'parent_id',
                'label'                 => "Parent Account",
                'type'                  => 'select2_nested',
                'entity'                => 'children',
                'attribute'             => 'name',
                'model'                 => "App\Models\Account",
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'industry',
                'type'                  => 'select2_from_array',
                'default'               => 'Other',
                'label'                 => 'Industry',
                'options'               => $this->options[3]->pluck('value', 'value'),
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'email',
                'label'                 => 'Email',
                'type'                  => 'text',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'address',
                'type'                  => 'select2_from_array',
                'label'                 => 'Address',
                'options'               => $this->options[4]->pluck('value', 'value'),
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Fax",
                'type'                  => 'text',
                'name'                  => 'fax',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Account Number",
                'type'                  => 'text',
                'name'                  => 'account_number',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Account Site",
                'type'                  => 'text',
                'name'                  => 'website',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'rating',
                'type'                  => 'select2_from_array',
                'label'                 => 'Rating',
                'options'               => $this->options[5]->pluck('value', 'value'),
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Ticker Symbol",
                'type'                  => 'text',
                'name'                  => 'ticker_symbol',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name'                  => 'ownership',
                'type'                  => 'select2_from_array',
                'label'                 => 'Ownership',
                'options'               => $this->options[6]->pluck('value', 'value'),
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Number of employee",
                'type'                  => 'text',
                'name'                  => 'number_of_employees',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Annual Revenur",
                'type'                  => 'text',
                'name'                  => 'annual_revenur',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "SIC code",
                'type'                  => 'text',
                'name'                  => 'sic',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Billing Address",
                'type'                  => 'text',
                'name'                  => 'billing_address',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Valid until",
                'type'                  => 'date_picker',
                'name'                  => 'valid_until',
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'dd/mm/yyyy',
                    'language' => 'en'
                ],
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'name' => 'description',
                'type' => 'ckeditor'
            ],
            [
                'label' => "Logo",
                'name'  => "logo",
                'type'  => 'image',
                'crop'  => true,
                'aspect_ratio' => 1,
                'default' => asset('uploads/profile/R.png'),
                'wrapperAttributes'     => $colMd6,
            ]
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
        $response = $this->traitStore();
        // $this->crud->model->fixTree();

        return $response;
    }
}
