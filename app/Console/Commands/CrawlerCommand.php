<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class CrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:revert 
        {--type=update : update/rollback}';

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
        $type = $this->option('type');
        if ($type == 'update'){
            $this->updateDatabase();
        }elseif ($type == 'rollback'){
            $this->rollback();
        }else{
            $this->warn('Not support');
        }


    }

    public function rollback(){
        try{
            $categories = Category::where('created_at', '>', '2018-07-19 08:38:08')->delete();
        }catch (\Exception $exception){
            $this->warn($exception->getMessage());
        }

    }

    public function updateDatabase(){
        try{
            $input = storage_path('files/cates.json');
            if (file_exists($input)){
                $content = file_get_contents($input);
                $cates_data = json_decode($content, true);
                foreach ($cates_data as $class){
                    $class_name = $class['name'];
                    $class_id = array_get($class, "id", 0);
                    // Tìm tên có tên giống như trên server
//                    $class_found = Category::where('name', $class_name)->first();
                    $class_found = Category::where('id', $class_id)->first();
                    foreach ($class['subject'] as $subject){
                        $new_subject = Category::create([
                            'name' => $subject['name'],
                            'status' => 2
                        ]);
                        $new_subject->makeChildOf($class_found);
                        foreach ($subject['content'] as $section){
                            $new_section = Category::create([
                                'name' => $section['name'],
                                'status' => 2
                            ]);
                            $new_section->makeChildOf($new_subject);

                            //Import từng bài học
                            foreach ($section['content'] as $lession){
                                $new_lession = Category::create([
                                    'name' => $lession['name'],
                                    'status' => 2
                                ]);
                                $new_lession->makeChildOf($new_section);

                                foreach (array_get($lession, 'children', []) as $child){
                                    $new_child = Category::create([
                                        'name' => $child['name'],
                                        'status' => 2
                                    ]);
                                    $new_child->makeChildOf($new_lession);
                                }
                            }
                        }
                    }
                }
                $this->info('import success');
            }else{
                $this->warn('You must gen file before');
            }
        }catch (\Exception $exception){
            $this->warn($exception->getMessage());
        }
    }
}
