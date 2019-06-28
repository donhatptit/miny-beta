<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guideline;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GuidelineRequest as StoreRequest;
use App\Http\Requests\GuidelineRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class GuidelineCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class GuidelineCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Guideline');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/guideline');
        $this->crud->setEntityNameStrings('guide', 'guides');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Column
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Title',
            'type' => "model_function",
            'function_name' => 'getTitleWithLink',
            'limit'         => 200
        ]);

        // Field
        $this->crud->addField([
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'content',
            'label' => 'Content',
            'type' => 'ckeditor',
            'extra_plugins'  => ['justify', 'oembed', 'widget', 'dialog', 'mathjax', 'tableresize'],
        ]);

        // add asterisk for fields that are required in GuidelineRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function show($id)
    {
        $guideline = Guideline::findOrFail($id);
        return view('admin.guideline_detail', ['guideline' => $guideline]);
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
