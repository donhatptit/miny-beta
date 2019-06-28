<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChemicalEquation;
use App\Models\Chemical;

class InitializeElastic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:elastic {--data=chemical: chemical/equation} {--action=create : create/delete/rebuild}';

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
        $option = $this->option('data');
        $action = $this->option('action');
        if($option == 'chemical'){
            if($action == 'create'){
                Chemical::createIndex($shards = null, $replicas = null);
                Chemical::putMapping($ignoreConflicts = true);
                Chemical::addAllToIndex();
            }elseif($action == 'rebuild'){
                Chemical::rebuildMapping();
            }elseif($action == 'delete'){
                Chemical::deleteIndex();
            }
        }elseif($option == 'equation'){
            if($action == 'create'){
                ChemicalEquation::createIndex($shards = null, $replicas = null);
                ChemicalEquation::putMapping($ignoreConflicts = true);
                ChemicalEquation::addAllToIndex();
            }elseif($action == 'rebuild'){
                ChemicalEquation::rebuildMapping();
            }elseif($action == 'delete'){
                ChemicalEquation::deleteIndex();
            }
        }
    }
}
