<?php
/**
 * Created by PhpStorm.
 * User: duongnam
 * Date: 03/01/2019
 * Time: 16:45
 */

namespace App\Colombo\Cache;
use App\Models\EquationTag;
use App\Helper\handleEquation;

class EquationCache
{
    public static function getEquationDemo(){
        $categories = EquationTag::select('id')->where('name','!=','0')->get();
        $equation_demo = [];
        foreach($categories as $category){
            $equation_data_one_cate = [];
            $equation_one_cate = $category->chemical_equations()->select('equation','slug')->take(4)->get();
            foreach ($equation_one_cate as $one_equation){
                $one_equation_data = handleEquation::result_sub($one_equation->equation);
                $equation_data_one_cate[$one_equation->slug] = $one_equation_data;
            }
            $equation_demo[] = $equation_data_one_cate;
        }
        return $equation_demo;
    }
}