<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\NewsCRUD\app\Http\Requests\TagRequest as StoreRequest;
use Backpack\NewsCRUD\app\Http\Requests\TagRequest as UpdateRequest;

class ReportCrudController extends CrudController
{
    private $reason = [
        'Sai chính tả',
        'Giải khó hiểu',
        'Giải sai',
        'Lỗi khác'
    ];

    public function setup()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Report");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/report');
        $this->crud->setEntityNameStrings('report', 'reports');
        $this->crud->enableDetailsRow();
//        $this->crud->allowAccess('details_row');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);
        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Date',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'     => 'user_id',
            'label'    => 'Người phản hồi',
            'type'     => 'closure',
            'function' => function ($report) {
                $creator_id = $report->user_id;
                $creator    = User::find($creator_id);
                if (is_object($creator)) {
                    return $creator->name;
                } else {
                    return 'Chưa xác định';
                }
            }
        ]);
        $this->crud->addColumn([
            'name' => 'device_info',
            'label' => 'Loại thiết bị',
            'type' => 'text'
        ]);


        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'desc');
        $this->crud->limit(10);
        // --------- FILTER
        $this->crud->addFilter([
            'name'  => 'device_info',
            'type'  => 'select2',
            'label' => 'Loại thiết bị'
        ], function () {
            $data = [
                'ios' => 'ios',
                'android' => 'android',
            ];
            return $data;
        }, function ($value) {
            $this->crud->addClause('where', 'device_info', $value);
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


        // remove button preview
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    public function showDetailsRow($id){
        $this->data['entry'] = $this->crud->getEntry($id);
        return view('vendor.backpack.crud.details_report', $this->data);

    }
}
