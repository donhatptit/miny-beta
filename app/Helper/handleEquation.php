<?php
/**
 * Created by PhpStorm.
 * User: duongnam
 * Date: 27/09/2018
 * Time: 10:43
 */

namespace App\Helper;


class handleEquation
{
    public static function result($equation_text){
        $equation = [];
        if (strpos($equation_text, '→') !== false){
            $concat = ['&#x27F6;'];
            $a = explode('→',$equation_text);
        }else{
            $concat = ['&#8652;'];
            $a = explode('↔',$equation_text);
        }
        $left = self::peelEquation($a[0]);
        $right = self::peelEquation($a[1]);

        $data_left = self::peelChemical($left);
        $data_right = self::peelChemical($right);
        $equation[] = array_merge($data_left[0],$concat,$data_right[0]);
        for ($i=1;$i<=3;$i++){
            $equation[] = array_merge($data_left[$i],$data_right[$i]);
        }
        return $equation;
    }
    public static function peelEquation($left_or_right){
        if(strpos($left_or_right,'+[') != false){
            $temp = explode('+',$left_or_right);
            $to_delete = [];
            foreach ($temp as $i => $one){
                if( (substr_count($one,'[') == 3) && ($one[0] == '[') ){
                    $temp[$i-1] = $temp[$i-1].'+'.$one;
                    $to_delete[] = $one;
                }
            }
            $array_part = array_diff($temp,$to_delete);
            $array_part = array_values($array_part);
        }elseif( (strpos($left_or_right,'+') !== false) && (strpos($left_or_right,'+[') == false) ){
            $temp = explode('+',$left_or_right);
//            dump($temp);
            $to_delete = [];
            foreach ($temp as $i => $one){
                $j = $i;
                $to_delete_one = '';
                while (substr_count($temp[$j],'[') < 3){
                    $j++;
                    $temp[$i] = $temp[$i].'+'.$temp[$j];
                    $to_delete_one = $to_delete_one.'+'.$temp[$j];
                }
                $to_delete[] = substr($to_delete_one,1); // loai bo dau '+'
            }
//            dump($to_delete);
            $array_part = array_diff($temp,$to_delete);
            $array_part = array_values($array_part);
        }else { $array_part[] = $left_or_right;}
        return $array_part;
    }
    public static function peelChemical($left_right){
        $state_array = [];
        $color_smell_array = [];
        $equation_left_right = [];
        $left_right_temp = [];
        $data_left_right = [];
        foreach ($left_right as $i => $one_chemical){
            $explode = explode('[',$one_chemical);
            if (substr_count($one_chemical,'[') == 3){
                $chemical = $explode[0];
                $state = substr_replace($explode[1], "", -1);
                if ($explode[3] != ']'){
                    $color_smell = substr_replace($explode[2], "", -1).','.substr_replace($explode[3], "", -1);
                }else{
                    $color_smell = substr_replace($explode[2], "", -1);
                }
                $state_array[] = $state;
                $color_smell_array[] = $color_smell;
            }else{
                $chemical = $explode[0]."[".$explode[1];
                $state = substr_replace($explode[2], "", -1);
                if ($explode[4] != ']'){
                    $color_smell = substr_replace($explode[3], "", -1).','.substr_replace($explode[4], "", -1);
                }else{
                    $color_smell = substr_replace($explode[3], "", -1);
                }
                $state_array[] = $state;
                $color_smell_array[] = $color_smell;
            }
            $equation_left_right[] = $chemical;
            $left_right_temp[] = $chemical; // luu cac chat voi he so trong phan ung de tiep tuc xu li phan sau
            if ($i + 1 < count($left_right)){
                $equation_left_right[] = '+';
            }
        }
        array_push($data_left_right,$equation_left_right,$state_array,$color_smell_array,$left_right_temp);
        return $data_left_right;
    }
    public static function result_sub($equation_text){
        $equation = self::result($equation_text);
        $equation_x = self::removeFactor($equation);
        // duyệt từng chất hóa học trong phương trình
        foreach($equation_x[3] as $key => $symbol){
                $symbol = preg_replace("/\d+/", "<sub>$0</sub>", $symbol);
                $dot = strpos($symbol,".<sub>");
                if($dot !== false){
                    $symbol = substr_replace($symbol,"",strpos($symbol,"</sub>",$dot),6);
                    $symbol = substr_replace($symbol,"",strpos($symbol,"<sub>",$dot),5);
                }
            $equation_x[0][$key*2] = $equation_x[4][$key].$symbol;
        }
        return $equation_x;
    }

    public static function removeFactor($equation_data){
    foreach ($equation_data[3] as $pos => $number_symbol_chemical){
        if( (strpos($number_symbol_chemical,')') !== false)
            && (substr($number_symbol_chemical,-1) != ')')
            && ctype_alpha($number_symbol_chemical[strpos($number_symbol_chemical,')')+1])){
            $equation_data[3][$pos] = explode(')',$number_symbol_chemical)[1];
            $equation_data[4][$pos] = explode(')',$number_symbol_chemical)[0];
        }else{
            if(ctype_alpha($number_symbol_chemical[0]) != true){
                for($k = 1;$k<strlen($number_symbol_chemical);$k++){
                    if( (ctype_alpha($number_symbol_chemical[$k]))
                        && ($number_symbol_chemical[$k] != 'n')
                        && ($number_symbol_chemical[$k-1] != '(')
                        && ($number_symbol_chemical[$k-1] != '[')
                    ){
                        $equation_data[3][$pos] = substr($number_symbol_chemical,$k);
                        $equation_data[4][$pos] = substr($number_symbol_chemical,0,$k);
                        break;
                    }elseif(
                        (ctype_alpha($number_symbol_chemical[$k]))
                        && ($number_symbol_chemical[$k] != 'n')
                        && ( ($number_symbol_chemical[$k-1] == '(')
                            || ($number_symbol_chemical[$k-1] == '['))
                    ){
                        $equation_data[3][$pos] = substr($number_symbol_chemical,$k-1);
                        $equation_data[4][$pos] = substr($number_symbol_chemical,0,$k-1);
                        break;
                    }
                }
            }else{
                $equation_data[4][$pos] = "";
            }
        }
    }
    return $equation_data;
    }

}