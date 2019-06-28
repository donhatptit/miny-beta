<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TopicRequest as StoreRequest;
use App\Http\Requests\TopicRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class TopicCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TopicCrudController extends CrudController
{
    public function setup()
    {
        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Topic');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/topic');
        $this->crud->setEntityNameStrings('topic', 'topics');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // Add columns
        $this->crud->addColumn([
            'name'  =>  'id',
            'label' => 'ID',
            'type'  => 'number',
        ]);
        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Date',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'  => 'name',
            'type'  => 'text',
            'label' => 'Tên topic'
        ]);
        $this->crud->addColumn([
            'name' => 'boolean_seo_title',
            'label' => "SEO Title",
            'type' => 'check'
        ]);
        $this->crud->addColumn([
            'name' => 'boolean_seo_description',
            'label' => "SEO Description",
            'type' => 'check'
        ]);
        // Add Field
        $this->crud->addField([
            'name'  => 'name',
            'type'  => 'text',
            'label' => 'Tên topic',
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'type'  => 'text',
            'label' => 'slug',
            'hint'  => 'Nếu để trống tự động gen theo name'
        ]);
        $this->crud->addField([
            'name'  => 'seo_title',
            'type'  => 'text',
            'label' => 'Seo_title'
        ]);
        $this->crud->addField([
            'name'  => 'seo_description',
            'type'  => 'textarea',
            'label' => 'Seo_description'
        ]);
//        if (!$user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))) {
//            $this->crud->addClause('where', 'created_by', '=', Auth::id());
//            $this->crud->denyAccess(['delete']);
//        }

        $this->crud->addFilter([
            'name' => 'name',
            'type' => 'text',
            'label'=>'Tìm kiếm theo tên'
        ],false,function($value){
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'id',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ID'
        ],false,function($value){
            $this->crud->addClause('where','id',$value);
        });

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in TopicRequest
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
