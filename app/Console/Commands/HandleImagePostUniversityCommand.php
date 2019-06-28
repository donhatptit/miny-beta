<?php

namespace App\Console\Commands;

use App\Models\UniversityAttribute;
use Illuminate\Console\Command;
use App\Core\HandleFileFromUrl;

class HandleImagePostUniversityCommand extends Command
{

    const CAN_NOT_OPEN_URL = -1;
    const CAN_NOT_SAVE_FILE = -2;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:university
     {--option=all : chon option xu ly all/id la id bai viet}
    {--created_by=all : chon id user hoac all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xử lý ảnh trong các bài viết về trường trong mục tuyển sinh';

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
        $this->info("Running ....");
        $option  = $this->option('option');
        $created_by = $this->option('created_by');

        if($option == 'all'){
            $total = 0;
            $posts_builder = UniversityAttribute::where('is_handle',UniversityAttribute::PENDING);
            if(is_numeric($created_by)){
                $posts_builder->where('created_by', $created_by);
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

                $post = UniversityAttribute::findOrFail($option);
                $this->saveHtmlHandled($post);

            }catch(\Exception $e){
                $this->error('Không tìm thấy bài viết có id = '.$option);
            }

        }else{
            $this->warn('Not support');
        }
    }

    public function saveHtmlHandled(UniversityAttribute $post){
        $this->info("Xử lý bài viết có  ID : " . $post->id);
        $is_handle = UniversityAttribute::FINISH;
        $content = $this->handleHtml($post->content,$post->id);
        if($content == self::CAN_NOT_SAVE_FILE || $content == self::CAN_NOT_OPEN_URL){
            $is_handle = $content;
        }
        if($is_handle !== self::CAN_NOT_SAVE_FILE && $is_handle !== self::CAN_NOT_OPEN_URL){
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
                    $download_path = $this->downloadMediaFromUrl($url);
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

    public function downloadMediaFromUrl($url)
    {
        $folder = 'university';
        $handle = new HandleFileFromUrl($url,$folder);
        return $handle->hanleMedia();
    }
}
