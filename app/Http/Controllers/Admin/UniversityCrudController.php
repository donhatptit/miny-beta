<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\University;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UniversityRequest as StoreRequest;
use App\Http\Requests\UniversityRequest as UpdateRequest;
use Illuminate\Http\Request as FilterRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class UniversityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UniversityCrudController extends CrudController
{
    public function setup()
    {
        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\University');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/university');
        $this->crud->setEntityNameStrings('university', 'universities');
        $this->crud->enableDetailsRow();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS

        $this->crud->addColumn([
            'name'  =>  'id',
            'label' => 'ID',
            'type'  => 'number',
        ]);
        $this->crud->addColumn([
            'name'  => 'updated_at',
            'label' => 'Ngày chỉnh sửa',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'  => 'code',
            'label' => 'CODE',
            'type'  => 'text',

        ]);
        $this->crud->addColumn([
            'name'  => 'keyword',
            'label' => 'Ký hiệu trường',
            'type'  => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'vi_name',
            'label' => 'Vi_Name',
            'type' => 'text',
            'limit' => 30,
        ]);
        $this->crud->addColumn([
            'name'          => 'status2',
            'label'         => 'Trạng thái',
            'type'          => "model_function",
            'function_name' => 'getStatusView',
            'limit'         => 200,
        ]);
        $this->crud->addColumn([
            'name'     => 'edited_by',
            'label'    => 'Người sửa',
            'type'     => 'closure',
            'function' => function ($university) {
               $user = $university->user;
               if($user){
                   return $user->name;
               }
               return "Không xác định";

            }
        ]);
        // ------ CRUD FIELDS
        $this->crud->addField([
            'name'  => 'vi_name',
            'label' => 'Tên tiếng việt:',
            'type'  => 'text',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'en_name',
            'label' => 'Tên tiếng anh :',
            'type'  => 'text',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'code',
            'label' => 'Mã trường',
            'type'  => 'text',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug (URL)',
            'type'  => 'text',
            'hint'  => 'Nếu để trống, tự động gen ra từ vi_name',
            // 'disabled' => 'disabled'
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'avatar',
            'label' => 'Ảnh đại diện của trường',
            'type'  => 'image',
            'upload'    => true,
            'crop'  => true,
            'aspect_ratio' => 1,
            'tab'   => 'Thông tin'

        ]);
        $this->crud->addField([
            'name'  => 'keyword',
            'label' => 'Tên viết tắt của trường',
            'type'  => 'text',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'phone',
            'label' => 'Số điện thoại liên hệ',
            'type'  => 'text',
            'tab'   =>  'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'email',
            'label' => 'Email',
            'type'  => 'email',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'address',
            'label' => 'Địa chỉ',
            'type'  => 'text',
            'tab'   => 'Thông tin',

        ]);
        $this->crud->addField([
            'name'  => 'website',
            'label' => 'Website',
            'type'  => 'text',
            'tab'  => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'established',
            'label' => 'Ngày thành lập',
            'type'  => 'text',
            'tab'   => 'Thông tin',
            'hint'  => 'Ví dụ : Ngày 1 tháng 1 năm 1111'
        ]);
        $this->crud->addField([
            'name'  => 'type',
            'label' => 'Loại hình',
            'type'  => 'select_from_array',
            'options' => [
                '0' =>'Công lập',
                '1' =>'Dân lập'
            ],
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'organization',
            'label' => 'Trực thuộc cơ quan',
            'type'  => 'text',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'scale',
            'label' => 'Quy mô đào tạo',
            'type'  => 'text',
            'tab'   => 'Thông tin',
            'hint'  => 'Ví dụ :1200 giảng viên và sinh viên'
        ]);
        $this->crud->addField([
            'name'  => 'google_map',
            'label' => 'Google map',
            'type'  => 'textarea',
            'tab' => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'kind',
            'label' => 'Loại cơ sở',
            'type'  => 'select_from_array',
            'options' => [
                '0' => 'Đại học',
                '1' => 'Cao đẳng',
            ],
            'tab'   => 'Thông tin',
        ]);
        // Location,
        $this->crud->addField([
            'name'  => 'location_id',
            'label' => 'Vị trí',
            'type'  => 'select2',
            'entity' => 'location',
            'attribute' => 'name',
            'model' => 'App\Models\Location',
            'tab'   => 'Thông tin',
        ]);
        $this->crud->addField([
            'name'  => 'description',
            'label' => 'Mô tả trường',
            'type'  => 'textarea',
            'tab'   => 'Thông tin'
        ]);
        $this->crud->addField([
            'label' => "Topics",
            'type' => 'select2_multiple',
            'name' => 'topics', // the method that defines the relationship in your Model
            'entity' => 'topics', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Topic", // foreign key model
            'pivot' => true,
            'tab'       => 'Thông tin',
        ]);
        if ($user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))){
            $this->crud->addField([    // ENUM
                'name' => 'is_approve',
                'label' => "Trạng thái duyệt",
                'type' => 'select_from_array',
                'options' => ['0' => 'Nháp', '1' => 'Được duyệt'],
                'tab'   => 'Kiểm duyệt'
            ]);
            $this->crud->addField([    // ENUM
                'name' => 'is_public',
                'label' => "Chế độ hiển thị",
                'type' => 'select_from_array',
                'options' => ['0' => 'Ẩn', '1' => 'Hiển thị'],
                'tab'   => 'Kiểm duyệt'
            ]);
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
//        if (!$user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))) {
//            $this->crud->addClause('where', 'created_by', '=', Auth::id());
//            $this->crud->denyAccess(['delete']);
//        }

        // --------- FILTER
        $this->crud->addFilter([
            'name'  => 'created_by',
            'type'  => 'select2_ajax',
            'label' => 'Người sửa',
            'placeholder' => 'Pick a User'
        ],
            route('admin.post.filter.users.ajax'),
            function($value) {
                $this->crud->addClause('where', 'edited_by', $value);
            });
        $this->crud->addFilter([
            'name'  => 'is_approve',
            'type'  => 'select2',
            'label' => 'Trạng thái duyệt'
        ], function () {
            $data = [
                0 => 'Chưa duyệt',
                1 => 'Đã duyệt',
            ];
            return $data;
        }, function ($value) {
            $this->crud->addClause('where', 'is_approve', $value);
        });

        $this->crud->addFilter([
            'name'  => 'is_public',
            'type'  => 'select2',
            'label' => 'Trạng thái public'
        ], function () {
            $data = [
                0 => 'Chưa public',
                1 => 'Đã pulic'
            ];
            return $data;
        }, function ($value) {
            $this->crud->addClause('where', 'is_public', $value);
        });
        $this->crud->addFilter([
            'name' => 'keyword',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ký hiệu trường'
        ],false,function($value){
            $this->crud->addClause('where', 'keyword', 'LIKE', "%$value%");
        });
        $this->crud->addFilter([
            'name' => 'id',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ID'
        ],false,function($value){
            $this->crud->addClause('where','id',$value);
        });
        $this->crud->addFilter([
            'name' => 'vi_name',
            'type' => 'text',
            'label'=>'Tìm kiếm theo tên trường trường'
        ],false,function($value){
            $this->crud->addClause('where', 'vi_name', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'updated_at',
            'label' => 'Thời gian sửa'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to);
            });

        $this->crud->enableAjaxTable();
        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in UniversityRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $request->request->add(['created_by' => Auth::id()]);
       // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $request->request->add(['edited_by' => Auth::id()]);
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function showDetailsRow($id)
    {
        $images = Image::where('university_id', $id)->get();
        $this->data['images'] = $images;
        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.detail_university', $this->data);
    }

    public function filterUniversity(FilterRequest $request)
    {
        $key = $request->input('term');
        $universities = University::where('vi_name','like','%'.$key.'%')->orWhere('keyword', 'LIKE', '%'.$key.'%')->get();
        return $universities->pluck('vi_name', 'id');
    }
}
