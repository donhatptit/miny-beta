<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ChangeStatusFormula extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formula:status';

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
        $root_formula = Category::where('slug','cong-thuc')->first();
        $categories = $root_formula->getDescendants();
        foreach ($categories as $category){
            $category->status = Category::DISPLAY_ALL;
            $category->save();
        }

    }
}
