<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Baum\Node;
use Illuminate\Console\Command;

class UpdateNumPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'num:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::table('categories')->orderBy('id')->chunk(50, function($categories){
           foreach($categories as $category){
               $ids = $this->getAllDescendantsId($category->id);

               $num_posts = Post::whereIn('category_id', $ids)->count();
               $num_approved_posts = Post::where('is_approve', 1)->whereIn('category_id', $ids)->count();

               \DB::table('categories')->where('id', $category->id)->update(['num_posts' => $num_posts, 'num_approved_posts' => $num_approved_posts]);
           }
        });
    }

    public function getAllDescendantsId($category_id){
        $category = Category::find($category_id);
        /** @var $root_cate Node*/
        $descendants = $category->getDescendantsAndSelf()->toArray();
        $descendant_ids = [];
        foreach ($descendants as $descendant){
            $descendant_ids[] = $descendant['id'];
        }

        return $descendant_ids;
    }
}
