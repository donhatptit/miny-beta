<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;

class DetectKindLiteratureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:kind
                        {--option=all/id :all tat ca bai viet mon van}';

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
        $this->info('Running...');
        $option = $this->option('option');
        if($option == 'all'){
            $this->detectTag();
        }elseif(is_numeric($option)){
            $post = Post::find($option);
            if(!$post){
                return $this->error('ID bạn yêu cầu không tồn tại');
            }
            $kind = $this->detectKindPost($post);
            $post_kind = $post->kinds->pluck('id')->toArray();
            if(!in_array($kind, $post_kind)){
                $post->kinds()->attach($kind);
            }
        }
    }
    public function detectTag(){
        $categories = Category::where('name','LIKE','Ngữ văn%')->where('depth',1)->get();
        foreach($categories as $cate){
            $this->getCateChild($cate);
        }
    }

    public function getCateChild($cate){
        $cate_child = $cate->getLeaves(['id']);
        $posts = Post::whereIn('category_id',$cate_child)->get();
        foreach($posts as $post){
            $kind = $this->detectKindPost($post);
            $post_kind = $post->kinds->pluck('id')->toArray();
            if(!in_array($kind, $post_kind)){
                $post->kinds()->attach($kind);
            }

        }

    }
    public function detectKindPost(Post $post)
    {
        if (preg_match('/(Phân tích|Hãy phân tích)/', $post->title, $matches)) {
            return Post::PHAN_TICH;
        } elseif (preg_match('/(Cảm nhận|Cảm nghĩ|Suy nghĩ|Phát biểu cảm nghĩ)/', $post->title, $matches)) {
            return Post::CAM_NHAN;
        } elseif (preg_match('/(^Soạn bài|^Hướng dẫn soạn bài)/', $post->title, $matches)) {

            return Post::SOAN_BAI;
        } elseif (preg_match('/(Tóm tắt)/', $post->title, $matches)) {
            return Post::TOM_TAT;
        } elseif (preg_match('/(^Tả|^Miêu tả)/', $post->title, $matches)) {
            return Post::MIEU_TA;
        } elseif (preg_match('/(^Kể chuyện|^Kể|^Em hãy kể)/', $post->title, $matches)) {
            return Post::KE_CHUYEN;
        } else {
            return Post::OTHER;
        }
    }
}
