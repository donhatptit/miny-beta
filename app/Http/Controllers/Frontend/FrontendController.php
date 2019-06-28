<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 6/22/18
 * Time: 13:46
 */

namespace App\Http\Controllers\Frontend;


use App\Colombo\Cache\Manager\MyCache;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Frontend\Item\CategoryRepository;
use App\Repositories\Frontend\Item\PostRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class FrontendController extends Controller
{
    /** @var CategoryRepository */
    protected $categoryRepository;

    /** @var PostRepository */
    protected $postRepository;

    public function __construct(CategoryRepository $categoryRepository = null, PostRepository $postRepository = null)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;

        View::share('header_categories', $this->getHeaderCategories());
        View::share('footer_categories', $this->getFooterCategories());
        $this->setIndexSEO();
    }

    /**
     * Danh muc header
     * @return mixed
     */
    protected function getHeaderCategories(){
        $cates = MyCache::get(config('cache_key.header_cates'), true);
        return $cates;
    }

    /**
     * Danh muc footer
     * @return mixed
     */
    public function getFooterCategories(){
        $cates = MyCache::get(config('cache_key.footer_cates'), true);

        return $cates;
    }

    /**
     * Cho phép trang được index hay không ?
     * @param bool $enable
     */
    public function setIndexSEO($enable = false){
        if ($enable) {
            SEOMeta::addMeta('robots', 'index,follow', 'name');
        } else {
            SEOMeta::addMeta('robots', 'NOINDEX, NOFOLLOW', 'name');
        }
    }
    public function setSeoMeta($title = "", $des = "", $seo_keyword = "", $url = "", $url_image = "", $option = [], $canonical = "")
    {
        $des_default_tiny = '';
        $des_default_long = config('seotools.meta.defaults.description');
//
//        //Title 65 – 70 ký tự
        $suffix_title = config('seotools.meta.defaults.suffix');
        $additional_title = config('seotools.meta.defaults.additional_title');
        if (strlen($title) < 10) {
            $title .= ' ' . $additional_title;
        } else if (strlen($title) <= 60) {
            $title .= $suffix_title;
        } else {
            $title = $title . $suffix_title;
        }

//        //Description
        if (strlen($des) < 80) {
            $des .= ' ' . $des_default_long;
        } else if (strlen($des) <= 175) {
            $des .= str_limit($des_default_long, 140, "");
        } else {
            $des = str_limit($des, 300, "") . $des_default_tiny;
        }
//        //Keywords ;
//
        if (empty($seo_keyword)) {
            $seo_keyword = config('seotools.meta.defaults.keywords');
        }

//        //Main
        SEOMeta::setTitle($title, false);
        SEOMeta::setDescription($des, false);
        SEOMeta::addKeyword($seo_keyword);

        if (empty($canonical)){
//            $canonical = url()->current();
            $path = parse_url(url()->current(), PHP_URL_PATH);
            $canonical = "https://cunghocvui.com".$path;
        }
        SEOMeta::setCanonical($canonical);
//
//        //OPEN GRAPH
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($des, false);
//        if (!empty($option['property'])){
//            \OpenGraph::addProperty('type', $option['property']);
//        }else{
//            \OpenGraph::addProperty('type', 'article');
//        }
        if ($url != '') {
            OpenGraph::setUrl($url);
        } else {
            OpenGraph::setUrl(url()->current());
        }
        if ($url_image != '') {
            OpenGraph::addImage($url_image);
        } else {//default
            OpenGraph::addImage(url(config('seotools.meta.defaults.image')));
        }
    }
    public function setSeoMetaChemicalEquation($title = "", $des = "", $seo_keyword = "", $url = "", $url_image = "", $option = [], $canonical = "")
    {
        $des_default_tiny = '';
        $des_default_long = config('seochemicalequation.meta.defaults.description');

//        //Description
        if (strlen($des) < 80) {
            $des .= ' ' . $des_default_long;
        } else if (strlen($des) <= 175) {
            $des .= str_limit($des_default_long, 140, "");
        } else {
            $des = str_limit($des, 300, "") . $des_default_tiny;
        }
//        //Keywords ;
//
        if (empty($seo_keyword)) {
            $seo_keyword = config('seochemicalequation.meta.defaults.keywords');
        }

//        //Main
        SEOMeta::setTitle($title, false);
        SEOMeta::setDescription($des, false);
        SEOMeta::addKeyword($seo_keyword);

        if (empty($canonical)){
//            $canonical = url()->current();
            $path = parse_url(url()->current(), PHP_URL_PATH);
            $canonical = "https://cunghocvui.com".$path;
        }
        SEOMeta::setCanonical($canonical);

//        //OPEN GRAPH
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($des, false);

        if ($url != '') {
            OpenGraph::setUrl($url);
        } else {
            OpenGraph::setUrl(url()->current());
        }
        if ($url_image != '') {
            OpenGraph::addImage($url_image);
        } else {//default
            OpenGraph::addImage(url(config('seochemicalequation.meta.defaults.image')));
        }
    }
}