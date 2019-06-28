<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionCategory;
use App\User;
use App\Http\Requests\QuestionRequest as StoreRequest;
use App\Http\Requests\QuestionRequest as UpdateRequest;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function setup()
    {
        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Question');
        $this->crud->setRoute(config('backpack.base.route_prefix','admin') . '/question');
        $this->crud->setEntityNameStrings('question', 'questions');

        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name'=>'id',
            'label'=>'ID',
            'type'=>'number',
        ]);

        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => 'Date',
            'type'  => 'date',
        ]);
        $this->crud->addColumn([
            'name'=>'code',
            'label'=>'CODE',
            'type'=>'text',
        ]);
        $this->crud->addColumn([
            'name'          => 'question',
            'label'         => 'Câu hỏi',
            'type'          => "model_function_custom",
            'function_name' => 'getTitleWithLink',
        ]);

        $this->crud->addColumn([
            'name'     => 'created_by',
            'label'    => 'Người tạo',
            'type'     => 'closure',
            'function' => function ($post) {
                $creator_id = $post->created_by;
                $creator    = User::find($creator_id);
                if (is_object($creator)) {
                    return $creator->name;
                } else {
                    return 'Chưa xác định';
                }
            }
        ]);
        $this->crud->addColumn([
            'label'     => 'Category',
            'type'      => 'select',
            'name'      => 'category_id',
            'entity'    => 'category',
            'attribute' => 'name',
            'model'     => "App\Models\QuestionCategory",
        ]);


        // ------ CRUD FIELDS

        //Nội dung chính
        $this->crud->addField([    // TEXT
            'name'        => 'question',
            'label'       => 'Câu hỏi',
            'type'        => 'textarea',
            'placeholder' => 'Your question here',
            'tab'         => 'Nội dung',
        ]);
        $this->crud->addField([    // TEXT
            'name'        => 'answer',
            'label'       => 'Câu trả lời',
            'type'        => 'textarea',
            'placeholder' => 'Your answer here',
            'tab'         => 'Nội dung',
        ]);
        $this->crud->addField([    // TEXT
            'name'        => 'number',
            'label'       => 'Câu hỏi số',
            'type'        => 'number',
            'placeholder' => 'Chỉ nhập số',
            'hint'        => 'Ví dụ : Câu 1 thì nhập số : 1',
            'tab'         => 'Nội dung',
        ]);

        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug (URL)',
            'type'  => 'text',
            'hint'  => 'Nếu để trống, tự động gen ra từ title',
            'tab'   => 'Nội dung',
        ]);

        $this->crud->addField([    // SELECT
            'label'     => 'Loại',
            'type'      => 'select2_root',
            'name'      =>'category_root',
            'entity'    => 'category',
            'attribute' => 'name',
            'data_source' => route('admin.category.question.get'),
            'tab'       => 'Nội dung',

        ]);
        $this->crud->addField([    // SELECT
            'name' => 'category_child_one',
            'label' => "Tập",
            'type' => 'select2_child1',
            'allows_null' => false,
            'data_source' => route('admin.category.question.get'),
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([    // SELECT
            'name' => 'category_id',
            'label' => "Vòng",
            'type' => 'select2_child2',
            'attribute' => 'name_parent',
            'entity'=>'category',
            'allows_null' => false,
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label'     => 'Tags',
            'type'      => 'select2_multiple',
            'name'      => 'tags', // the method that defines the relationship in your Model
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Tag", // foreign key model
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?,
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([    // TEXT
            'name'  => 'seo_title',
            'label' => 'SEO Title',
            'type'  => 'text',
            'hint'  => 'Chỉnh sửa SEO cho title, nếu để trống lấy theo Title (title cho seo trong khoảng 65-70 ký tự)',
            'tab'   => 'SEO'
        ]);
        $this->crud->addField([
            'name'  => 'seo_description',
            'label' => 'SEO description',
            'type'  => 'textarea',
            'hint'  => 'Nếu để trống lấy theo mặc định hệ thống',
            'tab' => 'SEO'
        ]);
        // Admin duyệt
        if ($user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))){
//             TAB sửa user bài viết
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
        $this->crud->enableAjaxTable();
        $this->crud->removeButton('show');
        //------ REVISIONS
        $this->crud->orderBy('created_at', 'desc');

        // ------ ADVANCED QUERIES
        // Nếu ko phải admin thì chỉ xem đc bài của mình
        if (!$user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))) {
            $this->crud->addClause('where', 'created_by', '=', Auth::id());
            $this->crud->denyAccess(['delete']);
        }

        // --------- FILTER
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
            'name'  => 'category',
            'type'  => 'select2',
            'label' => 'Danh mục'
        ], function () {
            $categories      = QuestionCategory::get();
            $data_categories = [];
            foreach ($categories as $category) {
                $data_categories[$category->id] = $category->name;
            }
            return $data_categories;
        }, function ($value) {
            $this->crud->addClause('where', 'category_id', $value);
        });
        $this->crud->addFilter([
            'name' => 'id',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ID'
        ],false,function($value){
            $this->crud->addClause('where','id',$value);
        });

        $this->crud->addFilter([
            'name' => 'question',
            'type' => 'text',
            'label'=>'Tìm kiếm theo Title'
        ],false,function($value){
            $this->crud->addClause('where', 'question', 'LIKE', "%$value%");
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


    }
    // hiênr thị thêm thông tin vể bải viết trên bảng thống kê
    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('details_row');

        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.question_details_row', $this->data);
    }


    public function store(StoreRequest $request)
    {
        $request->request->add(['created_by' => Auth::id()]);
        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        $request->request->add(['edited_by' => Auth::id()]);
        return parent::updateCrud($request);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;

        return parent::edit($id);
    }

    public function getCategory(Request $request){
        $id_category = $request->get('id_category');
        $parent_cate = QuestionCategory::find($id_category);
        if($request->type == 'root'){
            $categories = $parent_cate->getImmediateDescendants();
        }else{
            $categories = $parent_cate->getDescendants();
        }

        return $categories;
    }
}
