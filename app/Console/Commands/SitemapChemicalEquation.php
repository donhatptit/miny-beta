<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Core\SitemapChemicalEquationGenerator;

class SitemapChemicalEquation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:chemicalequation {--type=cate : cate/equation/chemical/reactant/product/all}';

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
        $option = $this->option('type');
        $generator = new SitemapChemicalEquationGenerator();
        if($option == 'cate'){
            $generator->genCate();
            $this->info('success!');
        }elseif($option == 'equation'){
            $generator->genEquation();
            $this->info('success!');
        }elseif($option == 'chemical'){
            $generator->genChemical();
            $this->info('success!');
        }elseif($option == 'reactant'){
            $generator->genEquation_Reactant();
            $this->info('success!');
        }elseif($option == 'product'){
            $generator->genEquation_Product();
            $this->info('success!');
        }elseif($option == 'all'){
            $generator->genCate();
            $generator->genEquation();
            $generator->genChemical();
            $generator->genEquation_Reactant();
            $generator->genEquation_Product();
            $this->info('success!');
        }
    }
}
