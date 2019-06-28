<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostAnswer;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PostAnswerRequest as StoreRequest;
use App\Http\Requests\PostAnswerRequest as UpdateRequest;

/**
 * Class PostAnswerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PostAnswerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\PostAnswer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/post-answer');
        $this->crud->setEntityNameStrings('postanswer', 'post_answers');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // ADD COLUMNS
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
            'name'     => 'post_id',
            'label'    => 'Post',
            'type'     => 'closure',
            'function' => function ($answer) {
                $post_id = $answer->post_id;
                $post    = Post::find($post_id);
                if (is_object($post)) {
                    return $post->getTitleWithLink();
                } else {
                    return 'Chưa xác định';
                }
            }
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
        // FIELD
        $this->crud->addField([    // TEXT
            'name'        => 'post_id',
            'label'       => 'Post ID',
            'type'        => 'number',
        ]);
        $this->crud->addField([    // TEXT
            'name'        => 'content',
            'label'       => 'Answer',
            'type'           => 'ckeditor',
            'placeholder'    => 'Your subject text here',
            'extra_plugins'  => ['justify', 'oembed', 'widget', 'dialog', 'mathjax', 'tableresize'],
        ]);

        // Filter
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
            'name' => 'post_id',
            'type' => 'text',
            'label'=>'Tìm kiếm theo ID bài viết'
        ],false,function($value){
            $this->crud->addClause('where','post_id',$value);
        });

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        // add asterisk for fields that are required in PostAnswerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
    public function destroy($id)
    {
        $answer_current = PostAnswer::find($id);
        $count_answer = PostAnswer::where('post_id', $answer_current->post_id)->count();
        if($count_answer < 2){
            $post = Post::find($answer_current->post_id);
            $post->is_public = Post::GOOGLE_NOINDEX;
            $post->save();
        }
        return parent::destroy($id);
    }
}
