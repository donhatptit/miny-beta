<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\User;
use Illuminate\Console\Command;

class PublicPostLiteratureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:public{
                            --option=literature : all/id/literature}';

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
        $option = $this->option('option');
        $this->info('Running.....');
        $user = User::where('email','lgh@cunghocvui.com')->orWhere('email','vj_crawler@cunghocvui.com')->pluck('id')->toArray();
        if($option == 'all'){
            $this->info('Public tất cả bải viết crawl');
            $posts = Post::whereIn('created_by',$user)->get();
            foreach($posts as $post){
                $post->is_public = Post::GOOGLE_INDEX;
                $post->save();
            }
        }elseif($option == 'literature'){

            $this->info('Public bài viết môn Văn');
            $categories = Category::where('name','LIKE','Ngữ văn%')->where('depth',1)->get();
            foreach($categories as $cate){
                $this->publicPost($cate);
            }
        }elseif(is_numeric($option)){
            $this->info('Public bài viết có ID là : ' . $option);
            $post = Post::find($option);
            if(!$post){
                return $this->error('Không có ID yêu cầu');
            }
            $post->is_public = Post::GOOGLE_INDEX;
            $post->save();
        }else{
            $this->info('Bạn nhập sai tùy chọn');
        }

        $this->info('DONE !!!');

    }

    public function publicPost($cate){
        $cate_child = $cate->getLeaves(['id']);
        $user = User::where('email','lgh@cunghocvui.com')->orWhere('email','vj_crawler@cunghocvui.com')->pluck('id')->toArray();
        $posts = Post::whereIn('created_by',$user)->whereIn('category_id',$cate_child)->get();
        foreach($posts as $post){
            $post->is_public = Post::GOOGLE_INDEX;
            $post->save();
        }

    }
}
