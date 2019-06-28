<?php

namespace App\Http\Controllers\Admin;

use App\Core\Html2Text;
use App\Models\Tag;
use App\Models\TsPost;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TsPostRequest as StoreRequest;
use App\Http\Requests\TsPostRequest as UpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class TsPostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TsPostCrudController extends CrudController
{
    public function setup()
    {

        $user_logged = Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\TsPost');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/ts-post');
        $this->crud->setEntityNameStrings('ts-post', 'ts_posts');
        $this->crud->enableDetailsRow();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // Add columns
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
            'name'  => 'title',
            'label' => 'Title',
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
            'name'     => 'created_by',
            'label'    => 'Người tạo',
            'type'     => 'closure',
            'function' => function ($post) {
                $user = $post->user;
                if($user){
                    return $user->name;
                }
                return "Không xác định";
            }
        ]);
        $this->crud->addColumn([
            'label'     => 'Topic',
            'type'      => 'select',
            'name'      => 'topic_id',
            'entity'    => 'topic',
            'attribute' => 'name',
            'model'     => "App\Models\Topic",
        ]);


        // ADD FIELD ;
        $this->crud->addField([
            'name'  => 'title',
            'type'  => 'text',
            'label' => 'Title',
            'tab'   => 'Nội dung',
        ]);
        $this->crud->addField([
            'name'  => 'slug',
            'type'  => 'text',
            'label' => 'Slug',
            'hint'  => 'Nếu để trống tự động gen theo title',
            'tab'   => 'Nội dung',
        ]);
        $this->crud->addField([    // WYSIWYG
            'name'           => 'content',
            'label'          => 'Content',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your textarea text here',
            'extra_plugins'  => ['justify', 'oembed', 'widget', 'dialog', 'mathjax', 'tableresize','contents', 'font'],
            'tab'            => 'Nội dung',
        ]);
        $this->crud->addField([
            'name'  => 'description',
            'label' => 'Description',
            'type'  => 'textarea',
            'hint'  => 'Mô tả khoảng 300 ký tự, nếu để trống tự động gen theo content',
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([
            'name'  => 'topic_id',
            'label' => 'Topic',
            'type'  => 'select2',
            'entity' => 'topic',
            'attribute' => 'name',
            'model' => 'App\Models\Topic',
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([
            'name'  => 'university_id',
            'label' => 'University',
            'type'  => 'select2',
            'entity' => 'university',
            'attribute' => 'vi_name',
            'model' => 'App\Models\University',
            'tab'   => 'Nội dung'
        ]);
        $this->crud->addField([
            'label' => "Tags",
            'type' => 'tags_input',
            'name' => 'tags_input',
            'tab'       => 'Nội dung',
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
        }else{

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

//        $this->crud->addFilter([
//            'name'  => 'category_post',
//            'type'  => 'select2_ajax',
//            'label' => 'Danh mục bài viết',
//            'placeholder' => 'Pick a category'
//        ],
//            route('admin.post.filter.category.ajax'),
//            function($value) {
//                $this->crud->addClause('where', 'category_id', $value);
//            });
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

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in TsPostRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function showDetailsRow($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.detail_ts_post', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $request->request->add(['created_by' => Auth::id()]);
        // your additional operations before save here
        $content = $post_status = $request->request->get('content');
        $description = $request->request->get('description');
        if(empty($description)){
            $description = $this->renderDescription($content);
        }
        $request->request->set('description', $description);
        $redirect_location = parent::storeCrud($request);

        // them tag cho bai viet
        $tags = $request->request->get('tags_input');
        $post_id = $this->crud->entry->id;
        $this->addTag($tags, $post_id);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // Gen lại slug theo title khi bài viết chưa approved
        $is_approve = $request->request->get('is_approve');
        if($is_approve == TsPost::NOT_APPROVE){
            $request->request->set('slug', null);
        }
        $request->request->add(['edited_by' => Auth::id()]);
        // update tag bai viet
        $tags = $request->request->get('tags_input');
        $post_id = $request->request->get('id');
        $tags_id = $this->addTag($tags, $post_id);
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        //update published_at
        $published_at = $this->crud->entry->published_at;
        if($published_at == null && $this->crud->entry->is_public == TsPost::GOOGLE_INDEX){
            $this->crud->entry->published_at = Carbon::now();
            $this->crud->entry->save();
        }
        return $redirect_location;
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

    public function addTag($tags, $post_id){
        $tags_id = [];
        if(!empty($tags)){
            $arr_tags = explode(',', $tags);
            foreach($arr_tags as $tag){
                $find_tag = Tag::where('name', $tag)->first();
                if(!$find_tag){
                    $find_tag = Tag::create(['name' => $tag]);
                }
                if(!$find_tag->ts_posts->contains($post_id)){
                    $find_tag->ts_posts()->attach($post_id);
                }
                $tags_id[] = $find_tag->id;
            }
        }
        // neu la update se xoa quan he khi xoa tag
            $post = TsPost::find($post_id);
            $post->tags()->sync($tags_id);

    }
}
