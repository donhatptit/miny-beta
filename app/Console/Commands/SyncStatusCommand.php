<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class SyncStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:status';

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
        $posts = Post::get();
        foreach ($posts as $post){
            $this->info('post_id: ' . $post->id);
            if ($post->status == 'PUBLISHED' && $post->is_approve == 0 && $post->is_public == 0){
                $post->is_public = 1;
                $post->is_approve = 1;
            }elseif ($post->status == 'DRAFT'){
                $post->is_public = 0;
                $post->is_approve = 0;
            }
            try{
                $save = $post->save();
                $this->info('success');
            }catch (\Exception $exception){
                $this->warn('Error ' . $exception->getMessage());
            }
        }
    }
}
