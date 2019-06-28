<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChemicalEquation;
use App\Helper\handleEquation;

class SeoEquationGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:equation ';

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
        ChemicalEquation::chunk(10, function ($rows){
//            $rows = ChemicalEquation::where('id',150)->get();
            foreach ($rows as $one_equation){

                $equation_detail_with_factor = handleEquation::result_sub($one_equation->equation);
                $equation_detail = handleEquation::removeFactor($equation_detail_with_factor);

                if(in_array('&#x27F6;',$equation_detail[0])){
                    $arrow_pos = array_search('&#x27F6;',$equation_detail[0]);
                }else { $arrow_pos = array_search('&#8652;',$equation_detail[0]); }
                $seo_title = '';
                $total_chemical = count($equation_detail[3]);
                foreach ($equation_detail[3] as $pos => $chemical){
                    if( ($pos*2 < $arrow_pos-1 || $pos*2 > $arrow_pos) && ($pos+1 != $total_chemical) ){
                        $seo_title = $seo_title.$chemical.' + ';
                    }elseif($pos*2 == $arrow_pos-1){
                        $seo_title = $seo_title.$chemical.' => ';
                    }else{
                        $seo_title = $seo_title.$chemical;
                    }
                }
                $seo_description = '';
                foreach ($equation_detail[3] as $rank => $chemical){
                    if($rank*2 >= $arrow_pos){
                        break;
                    }
                    if($rank*2 < $arrow_pos-1){
                        $seo_description = $seo_description.$chemical." + ";
                    }else{
                        $seo_description = $seo_description.$chemical;
                    }
                }
                $seo_title = $seo_title." | Cân bằng phương trình hóa học | Phương trình hóa học";
                if($one_equation->phenomenon != ''){

                    if($one_equation->phenomenon[-1] == "."){
                        $seo_description .= ". Cân bằng phương trình hóa học. Hiện tượng: $one_equation->phenomenon ";
                    }elseif($one_equation->phenomenon[-1] == ","){
                        dump($one_equation->phenomenon);
                        $seo_description = substr($seo_description.". Cân bằng phương trình hóa học. Hiện tượng: $one_equation->phenomenon",0, -1).". ";
                    }else{
                        $seo_description .= ". Cân bằng phương trình hóa học. Hiện tượng: $one_equation->phenomenon. ";
                    }
                }else{
                    $seo_description .= ". Cân bằng phương trình hóa học. ";
                }
                foreach ($one_equation->equation_tags as $pos => $cate){
                    if($cate->name != '0' && $pos+1 != $one_equation->equation_tags->count() ){
                        $seo_description = $seo_description.$cate->name." - ";
                    }elseif($cate->name != '0'){
                        $seo_description = $seo_description.$cate->name.".";
                    }
                }
                dump($one_equation->id);
                dump($seo_title);
                dump($seo_description);
                $one_equation->seo_title = $seo_title;
                $one_equation->seo_description = $seo_description;
                $one_equation->save();
            }
        });
    }
}
