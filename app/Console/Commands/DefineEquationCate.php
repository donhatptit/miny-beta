<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EquationTag;

class DefineEquationCate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'equation:definecate';

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
        $data = EquationTag::all();
        foreach ($data as $row){
            $define_cate = \config("equation_cate_define.$row->slug");
            $row->info = $define_cate;
            $row->save();
        }
    }
}
