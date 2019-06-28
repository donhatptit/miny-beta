<?php
/**
 * Created by PhpStorm.
 * User: duongnam
 * Date: 19/11/2018
 * Time: 11:24
 */

namespace App\Core;

use App\Helper\ElasticsearchParams;
use App\Helper\handleEquation;
use App\Helper\SearchingHandler;

use App\Models\Chemical;
use App\Models\ChemicalEquation;
use App\Models\EquationTag;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Roumen\Sitemap\Sitemap;

class SitemapChemicalEquationGenerator
{
    public function genCate(){
        $cates = EquationTag::where('name', '!=', '0')->get();
        /** @var $sitemap Sitemap*/
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'weekly');

        foreach ($cates as $cate) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('frontend.equation.listEquationbyCate', $cate->slug), Carbon::now(), 0.8, 'weekly');
        }
        $sitemaps_generated = $sitemap->generate('xml');

        try {
            $sitemap_namefile = $this->genPath('equationcate', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }
    }
    public function genEquation(){
        $equations = ChemicalEquation::all();
        /** @var $sitemap Sitemap*/
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'weekly');

        foreach ($equations as $equation) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('frontend.equation.equationDetail', $equation->slug), Carbon::now(), 0.8, 'weekly');
        }
        $name = 'equationdetail';
        $this->name_locate($sitemap, $name);
    }
    public function genChemical(){
        $chemicals = Chemical::select('symbol')->get();
        /** @var $sitemap Sitemap*/
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'weekly');

        foreach ($chemicals as $chemical) {
            //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
            $sitemap->add(route('frontend.equation.chemicalDetail', $chemical->symbol), Carbon::now(), 0.8, 'weekly');
        }
        $name = 'chemicaldetail';
        $this->name_locate($sitemap, $name);
    }
    public function genEquation_Reactant(){
        /** @var $sitemap Sitemap*/
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'weekly');

        $check_chemical = [];
//        dd(in_array('nam', $check_chemical));
        $equations = ChemicalEquation::select('id','equation')->get();
        foreach ($equations as $equation){
            $equation_detail_with_factor = handleEquation::result_sub($equation->equation);
            $equation_detail = handleEquation::removeFactor($equation_detail_with_factor);
            echo("id phuong trinh: ");
            dump($equation->id);
            foreach ($equation_detail[3] as $number => $chemical){
                $params = ElasticsearchParams::equationSearchParam($chemical,null,6500);
                $data_x = ChemicalEquation::complexSearch($params);
                $data_filted = SearchingHandler::filterEquationSearch($data_x,$chemical,null);
                $total = $data_filted->count();
                if( $total > 0 && !in_array($chemical, $check_chemical)){
                    $check_chemical[] = $chemical;
                    $sitemap->add(route('frontend.equation.chemicalReactantEquation', $chemical), Carbon::now(), 0.8, 'weekly');
                }
            }
        }
        $name = 'reactantequation';
        $this->name_locate($sitemap, $name);
    }
    public function genEquation_Product(){
        /** @var $sitemap Sitemap*/
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now(), 1, 'weekly');

        $check_chemical = [];
//        dd(in_array('nam', $check_chemical));
        $equations = ChemicalEquation::select('id','equation')->get();
        foreach ($equations as $equation){
            $equation_detail_with_factor = handleEquation::result_sub($equation->equation);
            $equation_detail = handleEquation::removeFactor($equation_detail_with_factor);
            echo("id phuong trinh: ");
            dump($equation->id);
            foreach ($equation_detail[3] as $number => $chemical){
                $params = ElasticsearchParams::equationSearchParam(null,$chemical,6500);
                $data_x = ChemicalEquation::complexSearch($params);
                $data_filted = SearchingHandler::filterEquationSearch($data_x,null,$chemical);
                $total = $data_filted->count();
                if( $total > 0 && !in_array($chemical, $check_chemical)){
                    $check_chemical[] = $chemical;
                    $sitemap->add(route('frontend.equation.chemicalProductEquation', $chemical), Carbon::now(), 0.8, 'weekly');
                }
            }
        }
        $name = 'productequation';
        $this->name_locate($sitemap, $name);
    }




    public function name_locate($sitemap,$name){
        $sitemaps_generated = $sitemap->generate('xml');

        try {
            $sitemap_namefile = $this->genPath($name, 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }
    }
    private function genPath($type, $part)
    {
        return $this->rootPath($type) . DIRECTORY_SEPARATOR . $type . "_" . $part . '.xml';
    }

    /**
     * Thư mục chứa tất cả sitemaps
     * @param null $type
     *
     * @return string
     */
    private function rootPath($type = null)
    {
        return 'sitemaps';
    }
    /**
     * Tao duong dan file tu loai sitemap va part
     * @param $type
     * @param $path
     *
     * @return string
     */
    public function getDisk()
    {
        return Storage::disk('public_sitemaps');
    }
}