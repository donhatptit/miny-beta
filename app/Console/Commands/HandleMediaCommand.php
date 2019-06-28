<?php

namespace App\Console\Commands;

use App\Core\HandleFileFromUrl;
use App\Http\Controllers\Api\V1\HandleMediaController;
use App\Models\Post;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class HandleMediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:media
    {--option=all : chon option xu ly all/id la id bai viet}
    {--status=not_approve : chon trang thai bai viet approve/not_approve}
    {--created_by=all : chon id user hoac all}';

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

    const CAN_NOT_OPEN_URL = -1;
    const CAN_NOT_SAVE_FILE = -2;

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
        $option  = $this->option('option');
        $this->info("Running ....");
        $status = $this->option('status');
        $created_by = $this->option('created_by');
        $is_approve= Post::NOT_APPROVE;
        if($status == 'approve'){
            $is_approve = Post::APPROVED;
        }elseif($status == 'not_approve'){
            $is_approve = Post::NOT_APPROVE;
        }else{
            $this->error('Bạn nhập sai status, tự động chọn bài chưa được duyệt');
        }

        if($option == 'all'){
            $total = 0;
            $posts_builder = Post::where('is_approve',$is_approve)->where('is_handle',Post::PENDING)->select('id','subject','content','slug','is_approve','created_by');
            if(is_numeric($created_by)){
                $posts_builder = $posts_builder->where('created_by', $created_by);
            }
            $posts_builder->chunk(100,function ($posts) use(&$total){
                foreach ($posts as $post){
                    $this->saveHtmlHandled($post);
                    $total++;
                }
            });

            $this->info("Xử lý file từ URL : Đã xử lý " . $total . " bài viết \n");
        }else if(is_numeric($option)){
            try{

                $post = Post::findOrFail($option);
                $this->saveHtmlHandled($post);

            }catch(\Exception $e){
                $this->error('Không tìm thấy bài viết có id = '.$option);
            }

        }else{
            $this->warn('Not support');
        }


    }
    public function saveHtmlHandled(Post $post){
        $this->info("Xử lý bài viết có  ID : " . $post->id);
        $is_handle = Post::FINISH;
        $subject = $this->handleHtml($post->subject,$post->id);
        if($subject == self::CAN_NOT_SAVE_FILE || $subject == self::CAN_NOT_OPEN_URL){
            $is_handle = $subject;
        }
        $content = $this->handleHtml($post->content,$post->id);
        if($content == self::CAN_NOT_SAVE_FILE || $content == self::CAN_NOT_OPEN_URL){
            $is_handle = $content;
        }
        if($is_handle !== self::CAN_NOT_SAVE_FILE && $is_handle !== self::CAN_NOT_OPEN_URL){
            $post->subject = $subject;
            $post->content = $content;
        }
        $post->is_handle = $is_handle;
        $post->save();
        $this->info("DONE !!!");
    }

    public function handleHtml($html, $id_post)
    {
        if (preg_match_all('/src="(.+?)"/', $html, $matches)) {
            $urls = array_get($matches, 1, []);
            if (!$urls) return $html;
            foreach ($urls as $url) {
                if (strpos($url, config('app.url')) === false) {
                    $download_path = $this->downloadMediaFromUrl($url, $id_post);
                    if($download_path == self::CAN_NOT_OPEN_URL || $download_path == self::CAN_NOT_SAVE_FILE){
                        return $download_path;
                    }else{
                        $this->info($url . " được chuyển thành : " . $download_path . "\n");
                        $html = str_replace($url, $download_path, $html);
                    }

                }
            }
        }

        return $html;
    }

    public function downloadMediaFromUrl($url, $folder)
    {
        $handle = new HandleFileFromUrl($url,$folder);
        return $handle->hanleMedia();
    }
}
