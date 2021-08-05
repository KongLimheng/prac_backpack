<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use App\Repositories\OptionRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

/**
 * Class OptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OptionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    protected $optionRepo;
    protected function setupReorderOperation()
    {

        // CRUD::set('reorder.max_level',3);
        CRUD::set('reorder.label', 'name');

    }
    public function setup()
    {
        $this->isParentId = request()->parent_id ?? '';
        CRUD::setModel(\App\Models\Option::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/option');
        CRUD::setEntityNameStrings('option', 'options');
        $this->optionRepo = resolve(OptionRepository::class);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if ($this->isParentId) {
            $this->crud->addClause('where', 'parent_id', '=', $this->isParentId);
        } else {
            $this->crud->addClause('where', 'parent_id', '=', null);
        }

        CRUD::addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '№',
            'orderable' => false,
        ])->makeFirstColumn();

        CRUD::addColumn([
            'name'      => 'code',
            'label'     => 'Code',
            'type'      => 'text',
        ]);
        Crud::addColumn(
            [
                'name' => 'fix',
                'label' => 'Name',
                'type' => "closure",
                'function' => function ($entry) {
                    return '<a href="' . route('option.index') . '?parent_id=' . $entry->id .'">'.$entry->name.'</a>';
                },
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->SearchName($searchTerm);
                }
            ]
        );
        CRUD::addColumn([
            'name'      => 'type',
            'label'     => 'Type',
            'type'      => 'text',
        ]);

        CRUD::addColumn([
            'name'      => 'name_khm',
            'label'     => 'Name Khm',
            'type'      => 'text',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    
    protected function setupCreateOperation($option = '')
    {
        $colMd6 = ['class' => 'form-group col-md-6'];
        CRUD::setValidation(OptionRequest::class);
        if($this->isParentId && !$option){
            CRUD::addField([
                'type'                  => 'hidden',
                'name'                  => 'parent_id',
                'default'               => $this->isParentId
            ]);
        }

        $this->crud->addFields([
            [
                'label' => 'code',
                'type' => 'text',
                'name' => 'code',
                'wrapperAttributes' => $colMd6
            ],
            [
                'label'                 => "Name",
                'type'                  => 'text',
                'name'                  => 'name',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Order",
                'type'                  => 'text',
                'name'                  => 'order',
                'wrapperAttributes'     => $colMd6,
            ],
            [
                'label'                 => "Name khm",
                'type'                  => 'text',
                'name'                  => 'name_khm',
                'wrapperAttributes'     => $colMd6,
            ],
            [

                'label'                 => "Active",
                'type'                  => 'flexi.checkbox_button',
                'name'                  => 'active',
                'wrapper'     => 'form-group col-md-4',
            ]
        ]);
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
        $parentID = $this->isParentId ? $this->optionRepo->findParent($this->isParentId) : '';
        if(!$parentID){
            Alert::error(trans('flexi.something_went_wrong'))->flash();
            return redirect(backpack_url('option/create?parent_id='.$this->isParentId))->withInput();
        }

        $response = $this->traitStore();
        return $response;
    }
}
