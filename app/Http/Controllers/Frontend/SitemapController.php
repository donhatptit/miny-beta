<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 1/18/17
 * Time: 08:27
 */

namespace App\Http\Controllers\Frontend;

use App\Core\SitemapGenerator;
use Illuminate\Http\Request;

class SitemapController extends FrontendController
{

    public function index(Request $request)
    {
        ob_clean();
        $sitemap      = new SitemapGenerator();
        $list_sitemap = $sitemap->getListSitemap();
        return response($list_sitemap['content'], 200, $list_sitemap['headers']);
    }

    public function detail($type, $part)
    {
        ob_clean();
        $sitemap = new SitemapGenerator();
        return response($sitemap->genSitemapContent($type, $part), 200, ['Content-type' => 'text/xml; charset=utf-8']);
    }
}