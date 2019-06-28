<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\QuestionCategory;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\QuestionCategoryRequest as StoreRequest;
use App\Http\Requests\QuestionCategoryRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class QuestionCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class QuestionCategoryCrudController extends CrudController
{
    public function setup()
    {
        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\QuestionCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix','admin') . '/question-category');
        $this->crud->setEntityNameStrings('questioncategory', 'question_categories');
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');

        /*
       |--------------------------------------------------------------------------
       | COLUMNS AND FIELDS
       |--------------------------------------------------------------------------
       */

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 3);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);
        $this->crud->addColumn([
            'name'=>'code',
            'label'=>'CODE',
            'type'=>'text',
        ]);
        $this->crud->addColumn([
            'name'          => 'question',
            'label'         => 'Name',
            'type'          => "model_function",
            'function_name' => 'getTitleWithLink',
            'limit'         => 200,
        ]);
        $this->crud->addColumn([
            'name'          => 'status2',
            'label'         => 'Trạng thái',
            'type'          => "model_function",
            'function_name' => 'getStatusView',
            'limit'         => 200,
        ]);

        $this->crud->addColumn([
            'name' => 'slug',
            'label' => 'Slug',
        ]);
        $this->crud->addColumn([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name',
            'model' => "App\Models\QuestionCategory",
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


        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'tab' => 'Nội dung'
        ]);
        $this->crud->addField([
            'name'  => 'player',
            'label' => 'Người chơi',
            'type'  => 'text',
            'hint'  => 'chỉ nhập khi đó là vòng',
            'tab' => 'Nội dung'
        ]);
        $this->crud->addField([
            'name' => 'type',
            'label' => 'Kiểu danh mục',
            'type' => 'select_from_array',
            'options' => [QuestionCategory::TYPE_NHANH_NHU_CHOP => 'Nhanh như chớp',QuestionCategory::TYPE_DO_VUI => 'Đố vui'],
            'tab' => 'Nội dung'
        ]);
        $this->crud->addField([
            'name'  => 'seo_title',
            'label' => 'SEO Title',
            'hint'  => 'Nếu để tuirống thì sẽ lấy theo title',
            'tab' => 'SEO'
        ]);
        $this->crud->addField([
            'name'  => 'seo_description',
            'label' => 'SEO description',
            'type'  => 'textarea',
            'hint'  => 'Nếu để trống lấy theo mặc định hệ thống',
            'tab' => 'SEO'
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
            // 'disabled' => 'disabled'
            'tab' => 'Nội dung'
        ]);
        $this->crud->addField([
            'label' => 'Parent',
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'name_parent',
            'model' => "App\Models\QuestionCategory",
            'tab' => 'Nội dung'
        ]);
        // Admin duyệt
        if ($user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))) {
            $this->crud->addField([    // ENUM
                'name' => 'is_approve',
                'label' => "Trạng thái duyệt",
                'type' => 'select_from_array',
                'options' => ['0' => 'Nháp', '1' => 'Được duyệt'],
                'tab' => 'Kiểm duyệt'
            ]);
            $this->crud->addField([    // ENUM
                'name' => 'is_public',
                'label' => "Chế độ hiển thị",
                'type' => 'select_from_array',
                'options' => ['0' => 'Ẩn', '1' => 'Hiển thị'],
                'tab' => 'Kiểm duyệt'
            ]);
        }

//        $this->crud->enableAjaxTable();
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');
        $this->crud->addButtonFromModelFunction('line','Delete','openDelete','beginning');


        // Filter
        $this->crud->addFilter([
            'name'  => 'is_approve',
            'type'  => 'select2',
            'label' => 'Trạng thái duyệt'
        ], function () {
            $data = [
                0 => 'Chưa duyệt',
                1 => 'Đã duyệt'
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
            'name' => 'slug',
            'type' => 'text',
            'label'=>'Tìm kiếm theo tên danh mục '
        ],false,function($value){
            $this->crud->addClause('where', 'slug', 'LIKE', "%$value%");
        });

    }



    // hiênr thị thêm thông tin vể bải viết trên bảng thống kê
    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('details_row');

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['count_question'] = Question::where('category_id',$id)->get()->count();

        return view('vendor.backpack.crud.detail_cate_question', $this->data);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    public function destroy($id)
    {
        $category = QuestionCategory::find($id)->children->count();
        $question = Question::where('category_id',$id)->count();
        if($category > 0 || $question > 0) {
            return 0;
        }else{
            return parent::destroy($id);
        }
    }
}
