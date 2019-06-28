<?php

namespace App\Http\Controllers\Admin;

use App\Models\University;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ImageRequest as StoreRequest;
use App\Http\Requests\ImageRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ImageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ImageCrudController extends CrudController
{
    public function setup()
    {

        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Image');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/image');
        $this->crud->setEntityNameStrings('image', 'images');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        //CRUD COLUMN
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
            'name'  => 'path',
            'label' => 'image',
            'type'  => 'image',
             'height' => '100px',
             'width' => '100px'
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
            'function' => function ($image) {
                $university = $image->university;
                if ($university) {
                    return $university->vi_name;
                }
                    return 'Chưa xác định';
            }
        ]);
        $this->crud->addColumn([
            'name'     => 'created_by',
            'label'    => 'Người tạo',
            'type'     => 'closure',
            'function' => function ($image) {
                $user = $image->user;
                if($user){
                    return $user->name;
                }
                return "Không xác định";
            }
        ]);

        // CRUD FEILD
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
            'tab'   => 'Nội dung',
        ]);
        $this->crud->addField([
            'name'  => 'path',
            'label' => 'Ảnh giới thiệu trường',
            'type'  => 'image',
            'upload'    => true,
            'crop'  => false,
            'aspect_ratio' => 1,
            'hint'  => 'Nên chọn ảnh to, rõ , nét',
            'tab'   => 'Nội dung',
        ]);
        $this->crud->addField([
            'name'  => 'disk',
            'label' => 'Disk',
            'type'  => 'select_from_array',
            'options' => [
                'public' =>'public',
            ],
            'tab'   => 'Nội dung',
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
        // Filter
        $this->crud->addFilter([
            'name' => 'title',
            'type' => 'text',
            'label'=>'Tìm kiếm theo title ảnh'
        ],false,function($value){
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
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
                $this->crud->addClause('where', 'edited_by', $value);
            });

        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'updated_at',
            'label' => 'Thời gian tạo'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to);
            });


        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in ImageRequest
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
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
