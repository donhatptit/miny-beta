<?php

namespace App\Console\Commands;

use App\Core\SitemapGenerator;
use Illuminate\Console\Command;

class GenSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create 
                            {type=all : Type sitemap was generated}';

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
        $type = $this->argument('type');
        $generator = new SitemapGenerator();
        switch($type){
            case 'all':
                $generator->genPosts();
                $generator->genCategories();
                $generator->genQuestions();
                $generator->genQuestionCategories();
                $generator->genPostAdmission();
                $generator->genUniversity();
                $this->info('Gen all sitemap success');
                break;
            case 'post':
                $generator->genPosts();
                $this->info('Gen post sitemap success');
                break;
            case 'category':
                $generator->genCategories();
                $this->info('Gen category sitemap success');
                break;
            case 'question':
                $generator->genQuestions();
                $this->info('Gen question sitemap success');
                break;
            case 'question_category':
                $generator->genQuestionCategories();
                $this->info('Gen category question sitemap success');
                break;
            case 'post_admission':
                $generator->genPostAdmission();
                $this->info('Gen post admission sitemap success');
                break;
            case 'university':
                $generator->genUniversity();
                $this->info('Gen university sitemap success');
                break;
            default:
                $this->warn('Loại sitemap không đúng');

        }
    }
}
