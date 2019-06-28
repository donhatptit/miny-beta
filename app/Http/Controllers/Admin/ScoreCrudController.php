<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ScoreRequest as StoreRequest;
use App\Http\Requests\ScoreRequest as UpdateRequest;

/**
 * Class ScoreCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ScoreCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Score');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/score');
        $this->crud->setEntityNameStrings('score', 'scores');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        //ADD COLUMNS
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
            'label'     => 'Tên',
            'type'      => 'text',
            'name'      => 'name',
        ]);
        $this->crud->addColumn([
            'label' => 'Điểm',
            'type'  => 'text',
            'name'  => 'point',
        ]);
        $this->crud->addColumn([
            'name'     => 'university_id',
            'label'    => 'University',
            'type'     => 'closure',
            'function' => function ($attribute) {
                $university = $attribute->university;
                if($university){
                    return $university->vi_name;
                }
                return "Không xác định";
            }
        ]);

        // Add Field;
        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Tên ngành',
            'type'  => 'text',
        ]);
        $this->crud->addField([
            'name'  => 'code',
            'label' => 'CODE',
            'type'  => 'text',
        ]);
        $this->crud->addField([
            'name'  => 'group_subject',
            'type'  => 'text',
            'label' => 'Tổ hợp môn',
            'hint'  => 'Ví dụ : A01,B01,B02'
        ]);
        $this->crud->addField([
            'name'  => 'point',
            'label' => 'Điểm',
            'type'  => 'number',
            'attributes'=> ['step' => 'any']
        ]);
        $this->crud->addField([
            'name'  => 'note',
            'label' => 'Ghi chú',
            'type'  => 'text'
        ]);
        $this->crud->addField([
            'name'  => 'year',
            'label' => 'Năm',
            'type'  => 'number',
        ]);
        $this->crud->addField([
            'name'  => 'university_id',
            'label' => 'Trường học',
            'type'  => 'select2',
            'entity' => 'university',
            'attribute' => 'vi_name',
            'model' => 'App\Models\University',
        ]);



        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in ScoreRequest
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
