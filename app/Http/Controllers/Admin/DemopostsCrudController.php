<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DemopostsRequest as StoreRequest;
use App\Http\Requests\DemopostsRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class DemopostsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DemopostsCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Demoposts');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/demoposts');
        $this->crud->setEntityNameStrings('demoposts', 'demoposts');
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Tên bài viết',
            'type' => "model_function",
            'function_name' => 'getTitleWithLink', // the method in your Model
            'limit' => 120, // Limit the number of characters shown
        ]);
        $this->crud->addColumn([
            'name' => 'content',
            'label' => 'Nội dung bài viết',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'title',
            'label' => 'Tên bài viết',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'content',
            'label' => 'Nội dung bài viết',
            'type' => 'ckeditor'
        ]);
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in DemopostsRequest
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
