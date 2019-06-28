<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\NewsCRUD\app\Http\Requests\CategoryRequest as StoreRequest;
use Backpack\NewsCRUD\app\Http\Requests\CategoryRequest as UpdateRequest;
use Illuminate\Support\Facades\Session;

class CategoryCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\Category");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/category');
        $this->crud->setEntityNameStrings('category', 'categories');
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        $this->crud->enableReorder('name', 2);

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
                                'name' => 'id',
                                'label' => 'ID',
                            ]);
        $this->crud->addColumn([
                                'name' => 'name',
                                'label' => 'Name',
                            ]);

        $this->crud->addColumn([
                                'name' => 'slug',
                                'label' => 'Slug',
                            ]);
        $this->crud->addColumn([
                                'name' => 'status',
                                'label' => 'Hiển thị',
        ]);
        $this->crud->addColumn([
                                'label' => 'Parent',
                                'type' => 'select',
                                'name' => 'parent_id',
                                'entity' => 'parent',
                                'attribute' => 'name',
                                'model' => "App\Models\Category",
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
                            ]);
        $this->crud->addField([
            'name'  => 'seo_title',
            'label' => 'SEO Title',
            'hint'  => 'Nếu để trống thì sẽ lấy theo title'
        ]);
        $this->crud->addField([
            'name'  => 'seo_description',
            'label' => 'SEO description',
            'type'  => 'textarea',
            'hint'  => 'Nếu để trống lấy theo mặc định hệ thống'
        ]);
        $this->crud->addField([
                                'name' => 'slug',
                                'label' => 'Slug (URL)',
                                'type' => 'text',
                                'hint' => 'Will be automatically generated from your name, if left empty.',
                                // 'disabled' => 'disabled'
                            ]);
        $this->crud->addField([    // SELECT
            'label'     => 'Lớp',
            'type'      => 'select2_category_root',
            'name'      =>'category_root',
            'model'    => $this->crud->getRelationModel('posts', -1),
            'attribute' => 'name',
            'data_source' => route('admin.category.get'),
        ]);
        $this->crud->addField([    // SELECT
            'name' => 'category_child_one',
            'label' => "Môn",
            'type' => 'select2_category_child1',
            'allows_null' => true,
            'data_source' => route('admin.category.get'),
        ]);
        $this->crud->addField([
                                'label' => 'Parent',
                                'type' => 'select2_category',
                                'name' => 'parent_id',
                                'entity' => 'parent',
                                'attribute' => 'name_parent',
                                'model' => "App\Models\Category",
                            ]);
        $this->crud->addField([
            'name'    => 'status',
            'label'   => 'Trạng thái hiển thị',
            'type'    => 'select_from_array',
            'options' => Category::DISPLAY_TEXT,
            'default' => 1
        ]);
        $this->crud->addField([
            'name'    => 'type',
            'label'   => 'Loại danh mục',
            'type'    => 'select_from_array',
            'options' => [
                'class' => 'Lớp học',
                'subject' => 'Môn học'
            ]
        ]);
        $this->crud->addField([
            'name'  => 'description_top',
            'label' => 'Mô tả trên',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your textarea text here',
        ]);
        $this->crud->addField([
            'name'  => 'description_bottom',
            'label' => 'Mô tả dưới',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your textarea text here',
        ]);

        //
        $this->crud->removeButton('show');
    }


    public function create()
    {
        $this->data['session_parent'] = Session::get('parent_id');
        return parent::create();
    }


    public function store(StoreRequest $request)
    {
        $save =  parent::storeCrud();
        if($save){
            Session::put('parent_id',$request->parent_id);
        }
        return $save;
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    // hiênr thị thêm thông tin trên bảng
    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('details_row');

        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.details_row', $this->data);
    }
}
