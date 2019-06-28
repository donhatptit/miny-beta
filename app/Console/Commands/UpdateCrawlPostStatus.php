<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\User;
use Illuminate\Console\Command;

class UpdateCrawlPostStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:crawl';

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
        $user = User::where('email', 'lgh@cunghocvui.com')->first();

        $post_builder = Post::where('id', '>', 58326)
            ->where('created_by', '<>', $user->id);

        dump($post_builder->where('status', '<>', Post::DISPLAY_ALL)->count());

        $post_builder->update(['status' => Post::DISPLAY_ALL]);
    }
}
