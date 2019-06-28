<?php

namespace App\Console\Commands;

use App\Helper\handleEquation;
use App\Models\ChemicalEquation;
use App\Models\EquationTag;
use Illuminate\Console\Command;

class SlugGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slug:gen {--type=cate: cate/equation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update slug for equation';

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
        if($option == 'cate'){
            EquationTag::chunk(10, function ($rows){
                foreach ($rows as $one){
                    dump($one->id);
                    $one->save();
                }
            });
        }elseif($option == 'equation'){
            ChemicalEquation::chunk(10, function ($rows){
//            $rows = ChemicalEquation::where('id',61)->get();
                foreach ($rows as $one){
                    $equation_data = handleEquation::result($one->equation);
                    $data_slug = $this->handleSlug($equation_data);
                    $slug = '';
                    foreach ($data_slug[0] as $i => $one_part){
                        if( ($i % 2 == 1) && ($equation_data[0][$i] != '+') ) {
                            $slug = $slug."/";
                        }else{
                            $slug = $slug.$one_part;
                        }
                    }
                    // kiem tra xem co lap ko, neu co thi may lan
                    $data_to_check = ChemicalEquation::select('slug')->where('id','<',$one->id)->get();
                    $repeat = 0;
                    foreach($data_to_check as $row){
                        if(strpos($row->slug, $slug) !== false){
                            $repeat++;
                        }
                    }
                    if($repeat > 0){
                        $slug = $slug."/".strval($repeat);
                    }
                    dump($one->id);
                    dump($slug);
                    $one->slug = $slug;
                    $one->save();
                }
            });
        }
    }
    public function handleSlug($equation_data){
        foreach ($equation_data[3] as $pos => $number_symbol_chemical){
            if( (strpos($number_symbol_chemical,')') !== false)
                && (substr($number_symbol_chemical,-1) != ')')
                && ctype_alpha($number_symbol_chemical[strpos($number_symbol_chemical,')')+1])){
                $equation_data[0][$pos*2] = explode(')',$number_symbol_chemical)[1];
            }else{
                if(ctype_alpha($number_symbol_chemical[0]) != true){
                    for($k = 1;$k<strlen($number_symbol_chemical);$k++){
                        if( (ctype_alpha($number_symbol_chemical[$k]))
                            && ($number_symbol_chemical[$k] != 'n')
                            && ($number_symbol_chemical[$k-1] != '(')
                            && ($number_symbol_chemical[$k-1] != '[')
                        ){
                            $equation_data[0][$pos*2] = substr($number_symbol_chemical,$k);
                            break;
                        }elseif(
                            (ctype_alpha($number_symbol_chemical[$k]))
                            && ($number_symbol_chemical[$k] != 'n')
                            && ( ($number_symbol_chemical[$k-1] == '(')
                            || ($number_symbol_chemical[$k-1] == '['))
                        ){
                            $equation_data[0][$pos*2] = substr($number_symbol_chemical,$k-1);
                            break;
                        }
                    }
                }
            }
        }
        return $equation_data;
    }
}
