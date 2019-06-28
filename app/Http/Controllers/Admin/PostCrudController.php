<?php

namespace App\Http\Controllers\Admin;

use App\Core\Html2Text;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostAnswer;
use App\Models\Tag;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PostRequest as StoreRequest;
use App\Http\Requests\PostRequest as UpdateRequest;
use Illuminate\Http\Request as FilterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostCrudController extends CrudController
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
        $this->crud->setModel("App\Models\Post");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/post');
        $this->crud->setEntityNameStrings('post', 'posts');
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
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
            'name'          => 'title',
            'label'         => 'Title',
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
            'name'=>'status',
            'label'=>'Status',
            'type' => "model_function",
            'function_name' => 'getStatusText',
        ]);
        $this->crud->addColumn([
           'name' => 'has_tag',
            'label' => "Has Tag",
            'type' => 'check'

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
            'model'     => "App\Models\Category",
        ]);

        // ------ CRUD FIELDS

        //Nội dung chính
        $this->crud->addField([    // TEXT
            'name'        => 'title',
            'label'       => 'Title',
            'type'        => 'text_check',
            'placeholder' => 'Your title here',
            'tab'         => 'Nội dung',
        ]);


        $this->crud->addField([
            'name'  => 'slug',
            'label' => 'Slug (URL)',
            'type'  => 'text',
            'hint'  => 'Nếu để trống, tự động gen ra từ title',
            // 'disabled' => 'disabled'
            'tab'   => 'Nội dung',
        ]);

        $this->crud->addField([
            'name'           => 'subject',
            'label'          => 'Subject',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your subject text here',
            'extra_plugins'  => ['justify', 'oembed', 'widget', 'dialog', 'mathjax', 'tableresize'],
            'tab'            => 'Nội dung',
        ]);

        $this->crud->addField([    // WYSIWYG
            'name'           => 'content',
            'label'          => 'Content',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your textarea text here',
            'extra_plugins'  => ['justify', 'oembed', 'widget', 'dialog', 'mathjax', 'tableresize'],
            'tab'            => 'Nội dung',
        ]);

        $this->crud->addField([    // SELECT
            'label'     => 'Lớp',
            'type'      => 'select2_root',
            'name'      =>'category_root',
            'entity'    => 'category',
            'attribute' => 'name',
            'data_source' => route('admin.category.get'),
            'tab'       => 'Nội dung',

        ]);
        $this->crud->addField([    // SELECT
            'name' => 'category_child_one',
            'label' => "Môn",
            'type' => 'select2_child1',
            'allows_null' => false,
            'data_source' => route('admin.category.get'),
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([    // SELECT
            'name' => 'category_id',
            'label' => "Bài học",
            'type' => 'select2_child2',
            'attribute' => 'name_parent',
            'entity'=>'category',
            'allows_null' => false,
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([
            'label' => "Tags",
            'type' => 'select2_multiple',
            'name' => 'tags', // the method that defines the relationship in your Model
            'entity' => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Tag", // foreign key model
            'pivot' => true,
            'tab'       => 'Nội dung',
        ]);
        $this->crud->addField([
            'label' => "Thể loại",
            'type' => 'select2_multiple',
            'name' => 'kinds', // the method that defines the relationship in your Model
            'entity' => 'kinds', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Kind", // foreign key model
            'pivot' => true,
            'tab'       => 'Môn văn',
            'hint'   => 'Chỉ dùng cho môn Văn, Hãy nhập thể loại cho bài viết'
        ]);
        $this->crud->addField([   // Textarea
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'tab' => 'Môn văn',
            'hint' => 'Nhập description hiển thị cho bài viết, khoảng 300 ký tự, Để trống tự động render theo content'
        ]);
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

        $this->crud->addField([
            'name'    => 'status',
            'label'   => 'Trạng thái hiển thị',
            'type'    => 'select_from_array',
            'options' => Post::DISPLAY_TEXT,
            'default' => Post::DISPLAY_DEFAULT,
            'tab'       => 'Ghi chú',
        ]);
        $this->crud->addField([
            'name'      => 'unapprove_reason',
            'label'     => 'Ghi chú',
            'type'      => 'text',
            'tab'       => 'Ghi chú',

        ]);
        // Admin duyệt
        if ($user_logged->hasRole(config('laravel-permission.default.roles_list.administrator'))){
//            $this->crud->addField([    // TEXT
//                'name'  => 'date',
//                'label' => 'Date',
//                'type'  => 'date',
//                'value' => date('Y-m-d'),
//                'tab'   => 'Kiểm duyệt'
//            ], 'create');
//            $this->crud->addField([    // TEXT
//                'name'  => 'date',
//                'label' => 'Date',
//                'type'  => 'date',
//                'tab'   => 'Kiểm duyệt'
//            ], 'update');
//            $this->crud->addField([    // ENUM
//                'name'  => 'status',
//                'label' => 'Status',
//                'type'  => 'enum',
//                'tab'   => 'Kiểm duyệt'
//            ]);
//            $this->crud->addField([    // ENUM
//                'name' => 'is_approve',
//                'label' => "Trạng thái duyệt",
//                'type' => 'select_from_array',
//                'options' => ['0' => 'Nháp', '1' => 'Được duyệt'],
//                'tab'   => 'Kiểm duyệt'
//            ]);
//            $this->crud->addField([    // ENUM
//                'name' => 'is_public',
//                'label' => "Chế độ hiển thị",
//                'type' => 'select_from_array',
//                'options' => ['0' => 'Ẩn', '1' => 'Hiển thị'],
//                'tab'   => 'Kiểm duyệt'
//            ]);
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




//        $this->crud->addField([    // CHECKBOX
//                                'name' => 'featured',
//                                'label' => 'Featured item',
//                                'type' => 'checkbox',
//                            ]);

        $this->crud->enableAjaxTable();
        $this->crud->removeButton('show');
        // ------ ACCESS

        $this->crud->orderBy('created_at', 'desc');
        $this->crud->limit(10);


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
            'name'  => 'is_approve',
            'type'  => 'select2',
            'label' => 'Trạng thái duyệt'
        ], function () {
            $data = [
                0 => 'Chưa duyệt',
                1 => 'Đã duyệt',
                -1 => 'Xem xét'
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
            'name'  => 'category_post',
            'type'  => 'select2_ajax',
            'label' => 'Danh mục bài viết',
            'placeholder' => 'Pick a category'
        ],
            route('admin.post.filter.category.ajax'),
            function($value) {
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
            'name' => 'title',
            'type' => 'text',
            'label'=>'Tìm kiếm theo Title'
        ],false,function($value){
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
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

        return view('vendor.backpack.crud.post_details_row', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $post_status = $request->request->get('status');
        if ($post_status == Post::DISPLAY_DEFAULT){
            $category_id = $request->request->get('category_id');
            if (!empty($category_id)){
                $category = Category::select(['id', 'status'])->find($category_id);
                $post_status = $category->status;
            }

        }
        $request->request->set('status', $post_status);

        $request->request->add(['created_by' => Auth::id()]);
        // Ren description nếu không nhập description
        $content = $post_status = $request->request->get('content');
        $description = $request->request->get('description');
        if(empty($description)){
            $description = $this->renderDescription($content);
        }
        $request->request->set('description', $description);
        // Dem so tu noi dung(content);
        $request->request->set('count_word', str_word_count(strip_tags($content)));

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

    public function filterByCategory(FilterRequest $request)
    {
        $key = $request->input('term');
        $categories = Category::where('name','like','%'.$key.'%')->get();
        return $categories->pluck('name', 'id');

    }

    public function filterByUser(FilterRequest $request)
    {
        $key = $request->input('term');
        $categories = User::where('name','like','%'.$key.'%')->get();
        return $categories->pluck('name', 'id');
    }

    public function destroy($id)
    {
        $count_answer = PostAnswer::where('post_id', $id)->count();
        if($count_answer > 0){
            return fasle;
        }else{
            return parent::destroy($id);
        }

    }
    public function renderDescription($content)
    {
        $html_to_text = new Html2Text($content);
        $content_text = $html_to_text->getPlainText();
        $content_text = str_replace(["\"", "\'", "(", ")", "*", "-", "_"], "", $content_text);
        if (strlen($content_text) > 300) {
            $desc = mb_substr($content_text, 0, 300);
        } else {
            $desc = $content_text;
        }
        $desc = str_replace(["\"", "\'", "(", ")", "*", "-", "_", "\\"], "", $desc);
        return $desc;
    }
}
