<?php

namespace App\Http\Controllers\Admin;

use App\Models\University;
use App\Models\UniversityAttribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UniversityAttributeRequest as StoreRequest;
use App\Http\Requests\UniversityAttributeRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Class UniversityAtrributeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UniversityAttributeCrudController extends CrudController
{
    public function setup()
    {
        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\UniversityAttribute');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/university-attribute');
        $this->crud->setEntityNameStrings('university-attribute', 'university_attributes');
        $this->crud->enableDetailsRow();
        $this->crud->enableExportButtons();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Add columns
        $this->crud->addColumn([
            'name'  => 'id',
            'type'  => 'number',
            'label' => 'ID',
        ]);
        $this->crud->addColumn([
            'name'  => 'created_at',
            'type'  => 'date',
            'label' => 'Thời gian tạo',
            'format' => 'H:i:s d/m/Y',
        ]);
        $this->crud->addColumn([
            'name'          => 'title',
            'label'         => 'Title',
            'type'          => "model_function",
            'function_name' => 'getTitleWithLink',
            'limit'         => 200,
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
        $this->crud->addColumn([
            'name'   => 'type',
            'label'  => 'Loại',
            'type'   => 'closure',
            'function'  => function($entry) {
                return array_get(UniversityAttribute::$text_type, $entry->type, 'Không xác định');
            }
        ]);
        $this->crud->addColumn([
            'name'  => 'year',
            'type'  => 'number',
            'label' =>  'Năm'

        ]);
        $this->crud->addColumn([
            'name'          => 'status',
            'label'         => 'Trạng thái',
            'type'          => "model_function",
            'function_name' => 'getStatusView',
            'limit'         => 200,
        ]);
        $this->crud->addColumn([
            'name'  => 'created_by',
            'label' => 'Người tạo',
            'type'  => 'closure',
            'function' => function ($university_attribute) {
                $user = $university_attribute->user;
                if($user){
                    return $user->name;
                }
                return "Không xác định";

            }
        ]);
        // Add Field;
        $this->crud->addField([
            'name'  => 'university_id',
            'label' => 'Trường học',
            'type'  => 'select2',
            'entity' => 'university',
            'attribute' => 'vi_name',
            'model' => 'App\Models\University',
            'tab'   => 'Nội dung',
        ]);
        $this->crud->addField([
            'name'  => 'title',
            'label' => 'Title',
            'type'  => 'text',
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug (URL)',
            'type'  => 'text',
            'hint'  => 'Nếu để trống, tự động gen ra từ title',
            // 'disabled' => 'disabled',
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([
            'name' => 'type',
            'label' => "Loại bài viết",
            'type' => 'select_from_array',
            'options' => UniversityAttribute::$text_type,
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([    // WYSIWYG
            'name'           => 'content',
            'label'          => 'Content',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your textarea text here',
            'tab'            => 'Nội dung',
        ]);
        $this->crud->addField(
            [   // date_picker
                'name'  => 'year',
                'type'  => 'number',
                'label' => 'Năm của bài viết',
                'tab'   => 'Nội dung',
            ]
        );
        $this->crud->addField([    // TEXT
            'name'  => 'seo_title',
            'label' => 'SEO Title',
            'type'  => 'text',
            'hint'  => 'Chỉnh sửa SEO cho title, nếu để trống lấy theo Title (title cho seo trong khoảng 65-70 ký tự)',
            'tab'   => 'SEO'
        ]);
        $this->crud->addField([    // TEXT
            'name'  => 'seo_description',
            'label' => 'SEO Description',
            'type'  => 'text',
            'hint'  => 'Chỉnh sửa Description cho SEO (SEO Description cho seo trong khoảng tren 160 ký tự)',
            'tab'   => 'SEO'
        ]);
        $this->crud->addField([    // ENUM
            'name' => 'is_handle',
            'label' => "Trạng thái duyệt",
            'type' => 'select_from_array_disable',
            'options' => UniversityAttribute::$status,
            'option_disable' => UniversityAttribute::FINISH,
            'tab'   => 'Kiểm duyệt'
        ]);
        if ($user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))){

            $this->crud->addField([    // ENUM
                'label'     => 'User',
                'type'      => 'select2',
                'name'      => 'created_by',
                'entity'    => 'user',
                'attribute' => 'name',
                'model'     => "App\User",
                'tab'       => 'Người tạo',
                'hint'  => 'Nếu không chọn, tự động lấy theo tên người tạo',

            ]);
        }

        if (!$user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))) {
            $this->crud->addClause('where', 'created_by', '=', Auth::id());
            $this->crud->denyAccess(['delete']);
        }


        //FILTER
        $this->crud->addFilter([
            'name' => 'id',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ID'
        ],false,function($value){
            $this->crud->addClause('where','id',$value);
        });
        $this->crud->addFilter([
            'name'  => 'university_id',
            'type'  => 'select2_ajax',
            'label' => 'Filter theo tên trường hoặc viết tắt',
            'placeholder' => 'Pick a University'
        ],
            route('admin.post.filter.university'),
            function($value) {
                $this->crud->addClause('where', 'university_id', $value);
            });
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
        $this->crud->addFilter([
            'name'  => 'year',
            'type' => 'select2',
            'label' => 'Năm bài viết',
        ], function(){
            return [
                2015 => 'Năm 2015',
                2016 => 'Năm 2016',
                2017 => 'Năm 2017',
                2018 => 'Năm 2018',
                2019 => 'Năm 2019',
                2020 => 'Năm 2020',
                2021 => 'Năm 2021',
                2022 => 'Năm 2022',
                2023 => 'Năm 2023',
            ];
        }, function($value){
            $this->crud->addClause('where', 'year', $value);
        });
        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();
        if(Request::get('type') !== null){
            $this->crud->addClause('where', 'type', Request::get('type'));
        }
        $this->crud->orderBy('updated_at', 'desc');
        // add asterisk for fields that are required in UniversityAtrributeRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function showDetailsRow($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.detail_university_attribute', $this->data);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        if (empty($request->get('created_by'))){
            $request->request->set('created_by', Auth::id());
        }
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        if (empty($request->get('created_by'))){
            $request->request->set('created_by', Auth::id());
        }
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
