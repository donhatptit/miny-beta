<?php

namespace App\Console\Commands;

use App\Core\Html2Text;
use App\Models\Post;
use Illuminate\Console\Command;

class RenderAttributePostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attribute:run
                            {--type=count : chon count/description}
                            {--option=all : chon all/id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command xử lý đếm số từ, detect thể loại và ren description cho môn văn với các tùy chọn : 
    --type:
        count : Đếm số từ của bài viết
        description : Ren description
    --option :
        all : xử lý tất cả các bài viết
        id : chỉ xử lý 1 ID nhập vào(nhập số)      
    ';

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
        $type = $this->option('type');
        $option = $this->option('option');

        if ($option == 'all') {
            Post::chunk(100, function($posts) use($type){
                foreach($posts as $post){
                    $this->handlePost($post, $type);
                }
            });
        } elseif (is_numeric($option)) {
            $post = Post::where('id', $option)->first();
            $this->handlePost($post, $type);
        } else {
            return $this->info('Bạn đã nhập sai ...');
        }
    }
    public function handlePost($post, $type){
        if($type == 'count'){
            $this->countWordPost($post);
        }elseif($type == 'description'){
            $this->renderDescription($post);
        }
    }

    public function countWordPost($post)
    {
            $content = strip_tags($post->content);
            $post->count_word = str_word_count(strip_tags($content));
            $post->save();
    }

    public function renderDescription($post)
    {
        $html_to_text = new Html2Text($post->content);
        $content_text = $html_to_text->getPlainText();
        $content_text = str_replace(["\"", "\'", "(", ")", "*", "-", "_"], "", $content_text);
        if (strlen($content_text) > 300) {
            $desc = mb_substr($content_text, 0, 300);
        } else {
            $desc = $content_text;
        }
        $desc = str_replace(["\"", "\'", "(", ")", "*", "-", "_", "\\"], "", $desc);
        $post->description = $desc;
        $post->save();
    }
}
