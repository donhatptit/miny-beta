<?php
/**
 * Created by PhpStorm.
 * User: duongnam
 * Date: 02/10/2018
 * Time: 21:51
 */

namespace App\Helper;


class SearchingHandler
{
    public static function peelInput($input){
        if(strpos($input,' ') !== false){
            $array_chemical =  explode(" ",$input);
        }elseif(strpos($input,'+') !== false){
            $array_chemical =  explode("+",$input);
        }else{
            $array_chemical[] = $input;
        }
        $string_raw = '';
        foreach ($array_chemical as $one_chemical){
            $string_raw = $string_raw." ".trim($one_chemical);
        }
        $string_chemical = trim($string_raw);
        return $string_chemical;
    }
    public static function checkEquation($input,$left_right,$length_orther,$equation,$arrow_pos,$flag){
        $string_chemical = self::peelInput($input);
        $array_chemical = explode(" ",$string_chemical);
        $i = 0;
        foreach ($array_chemical as $one_chemical){
            $one_chemical = $one_chemical."[";
            $chemical_pos = strpos($left_right,strtolower($one_chemical));
            if($flag == 'left'){
                $chemical_pos = $chemical_pos + $length_orther;
                if((strpos($left_right,strtolower($one_chemical)) === false)
                    || (strpos(strtolower($equation),strtolower($one_chemical)) > $arrow_pos)){
                    $i++;
                }elseif( self::filter_condition1($chemical_pos,$equation) ){
                    $i++;
                }elseif( self::filter_condition2($chemical_pos,$equation) ){
                    $i++;
                }
            }elseif($flag == 'right'){
                $chemical_pos = $chemical_pos + $length_orther;
                if((strpos($left_right,strtolower($one_chemical)) === false)
                    || (strpos(strtolower($equation),strtolower($one_chemical)) < $arrow_pos)){
                    $i++;
                }elseif( self::filter_condition1($chemical_pos,$equation) ){
                    $i++;
                }elseif( self::filter_condition2($chemical_pos,$equation) ){
                    $i++;
                }
            }
        }
        if($i == 0){
            return true;
        }else{
            return false;
        }

    }
    public static function filter_condition1($chemical_pos,$equation){
        if(($chemical_pos-1 >= 0)
            && (ctype_alpha($equation[$chemical_pos-1])
                || ($equation[$chemical_pos-1] == ')')
                || ($equation[$chemical_pos-1] == ']')) ){
            return true;
        }else{
            return false;
        }
    }
    public static function filter_condition2($chemical_pos,$equation){
        if(($chemical_pos -2 >= 0) && is_numeric($equation[$chemical_pos-1])
            && (ctype_alpha($equation[$chemical_pos-2])
                || ($equation[$chemical_pos-2] == ')')
                || ($equation[$chemical_pos-2] == ']')) ){
            return true;
        }else{
            return false;
        }
    }
    public static function filterEquationSearch($data_x,$chemical_left,$chemical_right){
        foreach($data_x as $i => $one){
            if(strpos($one->equation,'→') !== false){
                $arrow_pos = strpos($one->equation,'→');
                $left_right = explode('→',strtolower($one->equation));
            }elseif(strpos($one->equation,'↔') !== false){
                $arrow_pos = strpos($one->equation,'↔');
                $left_right = explode('↔',strtolower($one->equation));
            }
            if($chemical_left != null){
                $check_left = self::checkEquation($chemical_left,$left_right[0],0,$one->equation,$arrow_pos,'left');
            }else{ $check_left = true; }

            if($chemical_right != null){
                // lưu ý dấu mũi tên khi khi ở dạng hiển thị (ko phải HTML charcode) thì có strlen bằng 3 **
                $check_right = self::checkEquation($chemical_right,$left_right[1],strlen($left_right[0])+3,$one->equation,$arrow_pos,'right');
            }else{ $check_right = true;}

            if($check_left == false || $check_right == false){
                unset($data_x[$i]);
            }
        }
        return $data_x;
    }
    // loc cac phương trinh co chat la chat san pham
    public static function filterEquationMakeChemicalSearch($data_x,$one_chemical,$flag){
        foreach($data_x as $i => $one){
            if(strpos($one->equation,'→') !== false){
                $arrow_pos = strpos($one->equation,'→');
                $left_right = explode('→',strtolower($one->equation));
            }elseif(strpos($one->equation,'↔') !== false){
                $arrow_pos = strpos($one->equation,'↔');
                $left_right = explode('↔',strtolower($one->equation));
            }
            if($flag == 'right'){
                // lưu ý dấu mũi tên khi khi ở dạng hiển thị (ko phải HTML charcode) thì có strlen bằng 3 **
                $check_right = self::checkEquation($one_chemical,$left_right[1],strlen($left_right[0])+3,$one->equation,$arrow_pos,'right');
                if($check_right == false){
                    unset($data_x[$i]);
                }
            }elseif($flag == 'left'){
                $check_left = self::checkEquation($one_chemical,$left_right[0],0,$one->equation,$arrow_pos,'left');
                if($check_left == false){
                    unset($data_x[$i]);
                }
            }
        }
        return $data_x;
    }
    public static function filterChemicalSearch($data_searched,$user_type){
        foreach ($data_searched as $rank => $chemical_row){
            if(strpos(strtolower(trim($chemical_row->symbol)),strtolower(trim($user_type))) !== 0 && strpos(strtolower(trim($chemical_row->name_vi)),strtolower(trim($user_type))) !== 0 ){
                unset($data_searched[$rank]);
            }
            if(strtolower(trim($chemical_row->symbol)) == strtolower(trim($user_type)) || strtolower(trim($chemical_row->name_vi)) == strtolower(trim($user_type))){
                $to_change = $data_searched[$rank];
                unset($data_searched[$rank]);
            }
        }
        isset($to_change) ? $data_searched->prepend($to_change) : '';
        return $data_searched;
    }
}