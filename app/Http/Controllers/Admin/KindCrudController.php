<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\KindRequest as StoreRequest;
use App\Http\Requests\KindRequest as UpdateRequest;

/**
 * Class KindCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class KindCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Kind');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/kind');
        $this->crud->setEntityNameStrings('kind', 'kinds');


        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumn([
            'name' => 'color',
            'label' => 'Background Color',
            'type' => 'closure',
            'function' => function($entry) {
                return "<div style='background-color: ".$entry->color . " ;width :100%; height:20px'> ".$entry->color . "</div>";
            }
        ]);

        $this->crud->addField([    // TEXT
            'name'        => 'name',
            'label'       => 'Thể loại',
            'type'        => 'text',
            'placeholder' => 'Your title here',
        ]);
        $this->crud->addField([    // TEXT
            'name'        => 'color',
            'label'       => 'Màu thẻ tag',
            'type'        => 'color_picker',
            'hint'        => 'Chọn màu từng thẻ tag',
        ]);




        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in KindRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
