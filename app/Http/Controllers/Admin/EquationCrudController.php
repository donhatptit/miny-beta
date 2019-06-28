<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EquationRequest as StoreRequest;
use App\Http\Requests\EquationRequest as UpdateRequest;

/**
 * Class EquationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EquationCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ChemicalEquation');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/equation');
        $this->crud->setEntityNameStrings('equation', 'equations');
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
           'name' => 'id',
           'label' => 'ID',
            'type' => 'number'
        ]);

        $this->crud->addColumn([
           'name' => 'equation',
            'label' => 'Equation',
            'type' => 'text',
            'limit' => 150
        ]);
        $this->crud->addColumn([
            'name'     => 'created_by',
            'label'    => 'Người tạo',
            'type'     => 'closure',
            'function' => function ($post) {
                $creator_id = $post->created_by;
                $creator    = User::find($creator_id);
                if (is_object($creator)) {
                    return $creator->name;
                } else {
                    return 'Chưa xác định';
                }
            }
        ]);

        // --------- FILTER
        $this->crud->addFilter([
            'name'  => 'created_by',
            'type'  => 'select2_ajax',
            'label' => 'Người tạo',
            'placeholder' => 'Pick a User'
        ],
            route('admin.post.filter.users.ajax'),
            function($value) {
                $this->crud->addClause('where', 'created_by', $value);
            });

        $this->crud->enableAjaxTable();

    }

    // hiênr thị thêm thông tin vể bải viết trên bảng thống kê
    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('details_row');

        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.equation_details_row', $this->data);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
