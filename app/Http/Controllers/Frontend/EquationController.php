<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\ElasticsearchParams;
use App\Helper\handleEquation;
use App\Helper\SearchingHandler;

use App\Repositories\Frontend\Item\PostRepository;
use Illuminate\Http\Request;
use App\Models\EquationTag;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\ChemicalEquation;
use App\Models\Chemical;
use App\Repositories\Frontend\Item\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Colombo\Cache\Manager\che;

class EquationController extends FrontendController
{
    public function __construct(CategoryRepository $categoryRepository = null, PostRepository $postRepository = null)
    {
        parent::__construct($categoryRepository, $postRepository);
        View::share('category',$this->handleCategory());
    }

    public function index(){
//        $categories = EquationTag::select('id')->where('name','!=','0')->get();
//        $equation_demo = [];
//        foreach($categories as $category){
//            $equation_data_one_cate = [];
//            $equation_one_cate = $category->chemical_equations()->select('equation','slug')->take(4)->get();
//            foreach ($equation_one_cate as $one_equation){
//                $one_equation_data = handleEquation::result_sub($one_equation->equation);
//                $equation_data_one_cate[$one_equation->slug] = $one_equation_data;
//            }
//            $equation_demo[] = $equation_data_one_cate;
//        }
        $equation_category = Category::where('slug', 'phuong-trinh-hoa-hoc')->first();
        $equation_demo = MyCache::get(config('cache_key.equation_demo'), true);
        $this->setSeoMetaChemicalEquation(config('seochemicalequation.meta.chemicalequation.title'), config('seochemicalequation.meta.chemicalequation.description'));
        $this->setIndexSEO(true);
        return view('frontend.equation.index',[
            'equation_demo' => $equation_demo,
            'equation_category' => $equation_category
        ]);

    }
    public function listEquationbyCate($slug){
        $equation_data_one_page = [];
        $row = EquationTag::where('slug',$slug)->first();
        $category_name_raw = $row->name;
        if(strpos($category_name_raw, "Lớp") !== false){
            $category_name = "Phương trình hóa học ".$category_name_raw;
        }else{ $category_name = $category_name_raw; }
        $category = EquationTag::where('slug',$slug)->take(1)->get();
        foreach($category as $category){
            $cate = $category;
        }
        $one_page_equation = $row->chemical_equations()->paginate(20);

        foreach($one_page_equation as $one_equation){
            $one_equation_data = handleEquation::result_sub($one_equation->equation);
            $equation_data_one_page[$one_equation->slug] = $one_equation_data;
        }
        $define_cate = $row->info;
        $this->seoCate($category_name_raw);
        $this->setIndexSEO(true);
        return view('frontend.equation.list_by_cate',['equation_data_one_page'=> $equation_data_one_page,
            'category_name'=>$category_name,'one_page_equation'=>$one_page_equation,'define_cate'=>$define_cate,
            'cate'=>$cate]);

    }
    public function seoCate($category_name){
        if(strpos($category_name, "Lớp") === false) {
            $seo_title = "$category_name - Tổng hợp $category_name đầy đủ và chi tiết nhất";
        }else{
            $seo_title = "Phương trình hóa học ".$category_name." - Tổng hợp phương trình hóa học $category_name đầy đủ và chi tiết nhất\"";
        }
        $seo_description = "$category_name - Phương trình $category_name - Các phương trình hóa học thuộc $category_name được Cunghocvui tổng hợp lại một cách đầy đủ và chi tiết nhất. ";
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }
    public function equationDetail($slug){
        $one_equation = ChemicalEquation::select('id','slug','equation','condition','execute','phenomenon','extra','seo_title','seo_description')->where('slug',$slug)->first();
        if (!$one_equation){
            return redirect(route('frontend.equation.searchEquation'), 301);
        }
        $equation_detail = handleEquation::result_sub($one_equation->equation);
//        $equation_detail = handleEquation::removeFactor($equation_detail_with_factor);
        $chemical_factors = [];
        foreach ($equation_detail[4] as $rank => $factor ){
//            $one_factor = explode($equation_detail[3][$rank], $one_chemical_with_factor)[0];
            if($factor == ""){
                $chemical_factors[] = "1";
            }else{
                $chemical_factors[] = $factor;
            }
        }
        $data_equation_make_chemical = [];
        foreach ($equation_detail[3] as $number => $one_chemical){
            $params = ElasticsearchParams::equationMakeChemicalSearchParam($one_chemical,100);
            $data_x = ChemicalEquation::complexSearch($params);
            $data_filted = SearchingHandler::filterEquationMakeChemicalSearch($data_x,$one_chemical,'right');
            if(count($data_filted->toArray()) > 4) {
                $data_filted = array_slice($data_filted->toArray(),0,4);
            }
            foreach($data_filted as $one){
                $one_equation_data = handleEquation::result_sub($one['equation']);
                $data_equation_make_chemical[$number][$one['slug']] = $one_equation_data;
            }
        }
        $info_chemical_in_equation = $this->data_chemical_in_equation($equation_detail[3]);
        $this->setSeoMetaChemicalEquation($one_equation->seo_title, $one_equation->seo_description);
        $this->setIndexSEO(true);
        $header_title = $this->headerEquationDetail($equation_detail[0],$equation_detail[3]);
        return view('frontend.equation.equation_detail',['equation_detail' => $equation_detail,'one_equation'=>$one_equation,
            'data_equation_make_chemical'=>$data_equation_make_chemical,
            'info_chemical_in_equation'=>$info_chemical_in_equation,
            'chemical_factors'=>$chemical_factors,'header_title'=>$header_title]);
    }
    public function headerEquationDetail($symbols,$chemicals){
        $header_title = '';
        $break_pos = array_search('&#x27F6;',$symbols);
        $break_pos != null ? : $break_pos = array_search('&#8652;',$symbols);
        foreach ($chemicals as $pos => $chemical){
            if($pos*2 >= $break_pos){
                break;
            }
            if($pos*2 < $break_pos-1){
                $header_title = $header_title.$chemical." + ";
            }else{
                $header_title = $header_title.$chemical;
            }
        }
        $header_title = $header_title." - Cân bằng phương trình hóa học";
        return $header_title;
    }

    public function data_chemical_in_equation($array_chemical){
        $info_chemical_in_equation = [];
        foreach ($array_chemical as $one_chemical){

            $data_chemical = Chemical::select('g_mol','name_vi','symbol')->where('symbol',$one_chemical)->first();
            if(strpos($data_chemical['g_mol'],'±') !== false){
                $g_mol = explode('±', $data_chemical['g_mol'])[0];
            }else{
                $g_mol = $data_chemical['g_mol'];
            }
            $info_chemical_in_equation[$data_chemical['symbol']]['g_mol'] =  round($g_mol);
            $info_chemical_in_equation[$data_chemical['symbol']]['name_vi'] =  $data_chemical['name_vi'];
        }
        return $info_chemical_in_equation;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchEquation(Request $request){
        $a = "Mg(NO3)2.6H2O[][][]→5H2O[][][]+HNO3[][][]+Mg(OH)NO3[][][]";
//        dd(strlen('⇌'));
//        for ($l = 0; $l < strlen($a); $l++ ){
//            dump($l);
//            dump($a[$l]);
//        }
//        dd($a);
        $array_chemical_input['left'] = explode(" ",strtolower(trim(SearchingHandler::peelInput($request->chat_tham_gia))));
        $array_chemical_input['right'] = explode(" ",strtolower(trim(SearchingHandler::peelInput($request->chat_san_pham))));

        $params = ElasticsearchParams::equationSearchParam($request->chat_tham_gia,$request->chat_san_pham,6500);
        $data_x = ChemicalEquation::complexSearch($params);
        $data_filted = SearchingHandler::filterEquationSearch($data_x,$request->chat_tham_gia,$request->chat_san_pham);
        $total = $data_filted->count();

        $data = $this->createPagination($request,$data_filted,20);
        $equation_data_one_page = [];
        foreach ($data as $key => $one_equation){
            $one_equation_data = handleEquation::result_sub($one_equation->equation);
            $equation_data_one_page[$one_equation->slug] = $one_equation_data;
        }
        $reactant = str_replace(" ",", ",trim($request->chat_tham_gia));
        $product = str_replace(" ",", ",trim($request->chat_san_pham));
        $this->seoSearchEquation($request->chat_tham_gia, $request->chat_san_pham, $data->first());
            return view('frontend.equation.list_by_search',['equation_data_one_page'=> $equation_data_one_page,'total'=>$total,'data'=>$data,'array_chemical_input'=>$array_chemical_input,'reactant'=>$reactant,'product'=>$product]);
    }
    public function chemicalReactantEquation(Request $request){
        $keyword = trim($request->symbol);

        $params = ElasticsearchParams::equationSearchParam($request->symbol,null,6500);
        $data_x = ChemicalEquation::complexSearch($params);
        $data_filted = SearchingHandler::filterEquationSearch($data_x,$request->symbol,null);
        $total = $data_filted->count();

        $data = $this->createPagination($request,$data_filted,20);
        $equation_data_one_page = [];
        foreach ($data as $key => $one_equation){
            $one_equation_data = handleEquation::result_sub($one_equation->equation);
            $equation_data_one_page[$one_equation->slug] = $one_equation_data;
        }
        $this->seoChemicalReactantEquation($request->symbol);
        $this->setIndexSEO(true);
        return view('frontend.equation.list_reactant',['equation_data_one_page'=> $equation_data_one_page,'total'=>$total,'data'=>$data,'keyword'=>$keyword]);
    }
    public function seoChemicalReactantEquation($symbol){
        $seo_title = "$symbol - Tổng hợp các phương trình có $symbol là chất tham gia phản ứng";
        $seo_description = "Tổng hợp các phương trình có $symbol là chất tham gia đầy đủ và chi tiết nhất. Cân bằng phương trình có $symbol tham gia phản ứng.";
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }
    public function chemicalProductEquation(Request $request){
        $keyword = trim($request->symbol);
//        $string_chemical_input = SearchingHandler::peelInput(null)." ".SearchingHandler::peelInput($request->symbol);
//        $array_chemical_input = explode(" ",strtolower(trim($string_chemical_input)));
//        dd($array_chemical_input);
        $params = ElasticsearchParams::equationSearchParam(null,$request->symbol,6500);
        $data_x = ChemicalEquation::complexSearch($params);
        $data_filted = SearchingHandler::filterEquationSearch($data_x,null,$request->symbol);
        $total = $data_filted->count();

        $data = $this->createPagination($request,$data_filted,20);
        $equation_data_one_page = [];
        foreach ($data as $key => $one_equation){
            $one_equation_data = handleEquation::result_sub($one_equation->equation);
            $equation_data_one_page[$one_equation->slug] = $one_equation_data;
        }
        $this->seoChemicalProductEquation($request->symbol);
        $this->setIndexSEO(true);
        return view('frontend.equation.list_product',['equation_data_one_page'=> $equation_data_one_page,'total'=>$total,'data'=>$data,'keyword'=>$keyword]);
    }

    public function seoChemicalProductEquation($symbol){
        $seo_title = "$symbol - Tổng hợp các phương trình điều chế $symbol";
        $seo_description = "Tổng hợp các phương trình điều chế $symbol đầy đủ và chi tiết nhất. Cân bằng phương trình có sản phẩm là $symbol.";
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }
    public function seoSearchEquation($reactant, $product,$first_equation){
        $left = str_replace(" ","+",trim($reactant));
        $right = str_replace(" ","+",trim($product));
        if($left == '' && $right != ''){
            $seo_title = $right." | Cân bằng phương trình hóa học chính xác nhất";
        }elseif($right == '' && $left != ''){
            $seo_title = $left." | Cân bằng phương trình hóa học chính xác nhất ";
        }else{
            $seo_title = $left." = ".$right." | Cân bằng phương trình hóa học chính xác nhất";
        }
        $seo_description = $this->descriptionSearchEquation($first_equation);
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }
    public function descriptionSearchEquation($first_equation){
        if($first_equation != null){
            if($first_equation->phenomenon != ''){
                $seo_description = "Cân bằng phương trình hóa học. Hiện tượng: $first_equation->phenomenon ";
            }else{
                $seo_description = "Cân bằng phương trình hóa học.";
            }
            foreach ($first_equation->equation_tags as $pos => $cate){
                if($cate->name != '0' && $pos+1 != $first_equation->equation_tags->count() ){
                    $seo_description = $seo_description.$cate->name." - ";
                }elseif($cate->name != '0'){
                    $seo_description = $seo_description.$cate->name.".";
                }
            }
        }else{
            $seo_description = "Cân bằng phương trình hóa học.";
        }
        return $seo_description;
    }
    public function chemical(){
        $data_chemical = Chemical::paginate(20);
        $this->setSeoMetaChemicalEquation(config('seochemicalequation.meta.chemical.title'), config('seochemicalequation.meta.chemical.description'));
        $this->setIndexSEO(true);
        return view('frontend.equation.chemical',['data_chemical'=>$data_chemical]);
    }

    public function searchChemical(Request $request){
        if($request->chat_hoa_hoc == null){
            $request->chat_hoa_hoc = "";
        }
        $params = ElasticsearchParams::chemicalSearchParam($request->chat_hoa_hoc,3000);
        $data_searched = Chemical::complexSearch($params);
        $data_x = SearchingHandler::filterChemicalSearch($data_searched,$request->chat_hoa_hoc);

        $data_chemical = $this->createPagination($request,$data_x,8);
        $this->seoSearchChemical($data_chemical->first(),$request->chat_hoa_hoc);
        return view('frontend.equation.chemical_search_result',['data_chemical'=>$data_chemical]);
    }
    public function seoSearchChemical($data_chemical,$input){
        if($data_chemical != null){
            $name_vi = trim($data_chemical->name_vi);
            $color = $data_chemical->color != "" ? "- Màu sắc: $data_chemical->color " : "";
            $state = $data_chemical->state != "" ? "- $data_chemical->state ": "";
            $boling = $data_chemical->boiling_point != "" ? "- Nhiệt độ sôi: $data_chemical->boiling_point ": "";
            $meling = $data_chemical->melting_point != "" ? "- Nhiệt độ tan chảy: $data_chemical->melting_point ": "";
            if(substr_count($data_chemical->name_eng,';') >= 2){
                $split_name = explode('; ',$data_chemical->name_eng);
                $name_eng = "- Tên tiếng anh: $split_name[0]; $split_name[1]";
            }else{ $name_eng = "- Tên tiếng anh: $data_chemical->name_eng"; }
            $seo_title = "$data_chemical->symbol ($name_vi) - Chất hóa học";
            $seo_description = "$data_chemical->symbol ($name_vi) $color $state $boling $meling $name_eng. Tổng hợp các chất hóa học đầy đủ nhất tại Cunghocvui.";
        }else{
            $seo_title = $input." | "."Không tìm thấy kết quả";
            $seo_description = "Không tồn tại chất hóa học $input trong từ điển";
        }
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }
    public function chemicalDetail($symbol){
        $data_equation = [];
        $params = ElasticsearchParams::equationSearchParam("",$symbol,300);

        $equation_reactant = SearchingHandler::filterEquationSearch(ChemicalEquation::complexSearch($params),$symbol,null);
        $equation_reactant = $equation_reactant->unique()->slice(0,4);

        $equation_product =  SearchingHandler::filterEquationSearch(ChemicalEquation::complexSearch($params),null,$symbol);
        $equation_product = $equation_product->unique()->slice(0,4);

        $data_equation['reactant'] = $equation_reactant;
        $data_equation['product'] = $equation_product;

        $data_equation_chemical = [];
        foreach ($data_equation as $name => $one_type){
            foreach ($one_type as $one_equation){
                $one_equation_data = handleEquation::result_sub($one_equation->equation);
                $data_equation_chemical[$name][$one_equation->slug] = $one_equation_data;
            }
        }
        $data_chemical = Chemical::where('symbol',$symbol)->take(1)->get();
        if (count($data_chemical) == 0){
            return redirect(route('frontend.equation.chemical'), 301);
        }

        $this->seoChemical($data_chemical);
        $this->setIndexSEO(true);
        return view('frontend.equation.chemical_detail',['symbol'=>$symbol, 'data_chemical'=>$data_chemical,'data_equation_chemical'=>$data_equation_chemical]);
    }
    public function seoChemical($data_chemical){
        foreach ($data_chemical as $data_chemical){
            $name_vi = trim($data_chemical->name_vi);
            $color = $data_chemical->color != "" ? "- Màu sắc: $data_chemical->color " : "";
            $state = $data_chemical->state != "" ? "- $data_chemical->state ": "";
            $boling = $data_chemical->boiling_point != "" ? "- Nhiệt độ sôi: $data_chemical->boiling_point ": "";
            $meling = $data_chemical->melting_point != "" ? "- Nhiệt độ tan chảy: $data_chemical->melting_point ": "";
            if(substr_count($data_chemical->name_eng,';') >= 2){
                $split_name = explode('; ',$data_chemical->name_eng);
                $name_eng = "- Tên tiếng anh: $split_name[0]; $split_name[1]";
            }else{ $name_eng = "- Tên tiếng anh: $data_chemical->name_eng"; }
            $seo_title = "$data_chemical->symbol ($data_chemical->name_vi) - Thông tin cụ thể về $data_chemical->symbol ($data_chemical->name_vi) - Chất hóa học";
            $seo_description = "$data_chemical->symbol ($name_vi) $color $state $boling $meling $name_eng. Tổng hợp các chất hóa học đầy đủ nhất tại Cunghocvui.";
        }
        $this->setSeoMetaChemicalEquation($seo_title, $seo_description);
    }

    public function chemicalReactantAjax(Request $request){
        $terms = explode(" ",$request->chat_tham_gia);
        $term = trim(array_pop($terms));
        return $this->dataAjax($term);
    }
    public function chemicalProductAjax(Request $request){
        $terms = explode(" ",$request->chat_san_pham);
        $term = trim(array_pop($terms));
        return $this->dataAjax($term);
    }
    public function chemicalAjax(Request $request){
        $term = $request->chat_hoa_hoc;
        return  $this->dataAjax($term);
    }

    public function dataAjax($term){
        if (empty($term)) {
            return [];
        }
        $params = ElasticsearchParams::chemicalSearchParam($term,3000);
        $data_searched = Chemical::complexSearch($params);
        $data_x = SearchingHandler::filterChemicalSearch($data_searched,$term);
        $data = $data_x->slice(0,10);
        $formated_data = [];
        foreach ($data as $one_chemical){
            $formated_data[] = [$one_chemical->symbol, $one_chemical->name_vi];
        }
        return $formated_data;
    }
    public function dissolubilityTable(){
        $this->setIndexSEO(true);
        $this->setSeoMeta(config('seochemicalequation.meta.dissolubilityTable.title'), config('seochemicalequation.meta.dissolubilityTable.description'));
        return view('frontend.equation.dissolubility_table_tool');
    }
    public function periodicTable(){
        $this->setIndexSEO(true);
        $this->setSeoMeta(config('seochemicalequation.meta.periodicTable.title'), config('seochemicalequation.meta.periodicTable.description'));
        return view('frontend.equation.periodic_table_tool');
    }
    public function electrochemicalTable(){
        $this->setIndexSEO(true);
        $this->setSeoMeta(config('seochemicalequation.meta.electrochemicalTable.title'), config('seochemicalequation.meta.electrochemicalTable.description'));
        return view('frontend.equation.electrochemical_table_tool');
    }
    public function reactivityseriesTable(){
        $this->setIndexSEO(true);
        $this->setSeoMeta(config('seochemicalequation.meta.reactivityseriesTable.title'), config('seochemicalequation.meta.reactivityseriesTable.description'));
        return view('frontend.equation.reactivityseries_table_tool');
    }
    public function createPagination($request,$data_x,$perPage){
        if ($request->input('page') == null) {
            $page = 1;
        } else { $page = $request->input('page');}

//        $perPage = 8;
        $offset = ($page-1)*$perPage;
        $itemsForCurrentPage = $data_x->slice($offset, $perPage)->all();
        $data = new LengthAwarePaginator( $itemsForCurrentPage, count($data_x), $perPage, LengthAwarePaginator::resolveCurrentPage(),array('path' => LengthAwarePaginator::resolveCurrentPath()));
        return $data;
    }
    public function handleCategory()
    {
        $category = EquationTag::select('name','slug')->where('name','!=','0')->get();
        return $category;
    }
}

