<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TokenDeviceRequest as StoreRequest;
use App\Http\Requests\TokenDeviceRequest as UpdateRequest;

/**
 * Class TokenDeviceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TokenDeviceCrudController extends CrudController
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
        $this->crud->setModel('App\Models\TokenDevice');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/token-device');
        $this->crud->setEntityNameStrings('tokendevice', 'token_devices');


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
            'name'=>'id',
            'label'=>'ID',
            'type'=>'number'
        ]);
        $this->crud->addColumn([
            'name'     => 'user_id',
            'label'    => 'User',
            'type'     => 'closure',
            'function' => function ($token) {
                $id = $token->user_id;
                $user    = User::find($id);
                if (is_object($user)) {
                    return $user->name;
                } else {
                    return 'Chưa xác định';
                }
            }
        ]);
        $this->crud->addColumn([
            'name' => 'token_device',
            'label'=> 'Token Device',
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Thời gian tạo',
            'type' => 'date'
        ]);

        // --------- FILTER
        $this->crud->addFilter([
            'name'  => 'user_id',
            'type'  => 'select2_ajax',
            'label' => 'User',
            'placeholder' => 'Pick a User'
        ],
            route('admin.post.filter.users.ajax'),
            function($value) {
                $this->crud->addClause('where', 'user_id', $value);
            });

        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'created_at',
            'label' => 'Thời gian tạo'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to);
            });

        $this->crud->enableAjaxTable();

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
