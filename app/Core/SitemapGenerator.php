<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 7/4/18
 * Time: 09:34
 */

namespace App\Core;


use App\Models\Category;
use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\TsPost;
use App\Models\University;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Roumen\Sitemap\Sitemap;

class SitemapGenerator
{
    /**
     * Gen sitemap cho các bài post
     * @return bool
     * @throws \Exception
     */
    public function genPosts()
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make("sitemap");
        Post::where('is_public', Post::GOOGLE_INDEX)
            ->where('is_approve', Post::APPROVED)
            ->chunk(100,function($posts) use($sitemap){
                foreach ($posts as $post) {
                    $sitemap->add($post->link, $post->updated_at, '0.8', 'weekly');
                }
            });

        $sitemaps_generated = $sitemap->generate('xml');

        try {
            $sitemap_namefile = $this->genPath('post', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }

    }

    public function genCategories(){
        /** @var Sitemap $sitemap */
        $sitemap = App::make("sitemap");
        Category::with(['posts'])
            ->whereIn('status', [Category::DISPLAY_WEB, Category::DISPLAY_ALL])
            ->chunk(100, function($categories) use ($sitemap){
                foreach ($categories as $category){
                    if (count($category->posts) > 0){
                        $link = route('frontend.category.index', [
                            'slug' => $category->slug]);
                        $sitemap->add($link, $category->updated_at, '0.8', 'daily');
                    }
                }
            });

        $sitemaps_generated = $sitemap->generate('xml');
        try {
            $sitemap_namefile = $this->genPath('category', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }

    }

    public function genQuestionCategories(){

        $sitemap = App::make("sitemap");
        QuestionCategory::where('is_public', QuestionCategory::GOOGLE_INDEX)
            ->where('is_approve', QuestionCategory::APPROVED)
            ->chunk(100, function($categories) use($sitemap){
                foreach($categories as $category){
                    $link = route('frontend.question',
                        ['code' => $category->code, 'slug' => $category->slug]);
                    $sitemap->add($link, $category->updated_at, '0.8', 'daily');
                }
        });

        $sitemaps_generated = $sitemap->generate('xml');

        try {
            $sitemap_namefile = $this->genPath('question_category', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }
    }

    public function genQuestions(){
        $categories = QuestionCategory::where('is_public', QuestionCategory::GOOGLE_INDEX)->where('is_approve', QuestionCategory::APPROVED)->pluck('id')->toArray();

        $sitemap = App::make("sitemap");
        Question::whereIn('category_id', $categories)->chunk(100, function($questions) use ($sitemap){
            foreach($questions as $question){
                $link = route('frontend.question.detail', [
                    'code' => $question->code,
                    'slug' => $question->slug
                ]);
                $sitemap->add($link, $question->updated_at, '0.8', 'daily');
            }
        });

        $sitemaps_generated = $sitemap->generate('xml');

        try {
            $sitemap_namefile = $this->genPath('question', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }

    }
    /** Gen sitemap cho phần tuyển sinh */
    public function genPostAdmission(){
        $sitemap = App::make("sitemap");
        $posts = TsPost::where('is_public', TsPost::GOOGLE_INDEX)
                ->where('is_approve', TsPost::APPROVED)
                ->orderBy('published_at')
                ->chunk(100,function($posts) use($sitemap){
                foreach ($posts as $post) {
                    $link = route('admission.university.post', [
                        'slug' => $post->slug
                    ]);
                    $sitemap->add($link, $post->published_at, '0.8', 'weekly');
                }
            });
        $sitemaps_generated = $sitemap->generate('xml');
        try {
            $sitemap_namefile = $this->genPath('post_admission', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }
    }

    public function genUniversity(){
        $sitemap = App::make("sitemap");
        University::where('is_approve', University::APPROVED)
                        ->where('is_public', University::GOOGLE_INDEX)
                        ->orderBy('updated_at')
                        ->chunk(100, function($universities) use ($sitemap){
                            foreach ($universities as $university) {
                                $link_info = route('university.index', [
                                    'slug' => $university->slug
                                ]);
                                $link_score = route('university.score', [
                                    'slug' => $university->slug
                                ]);
                                $link_news = route('university.news', [
                                    'slug' => $university->slug
                                ]);
                                $link_images = route('university.show_image', [
                                    'slug' => $university->slug
                                ]);
                                $sitemap->add($link_info, $university->updated_at, '0.8', 'weekly');
                                $sitemap->add($link_score, $university->updated_at, '0.8', 'weekly');
                                $sitemap->add($link_news, $university->updated_at, '0.8', 'weekly');
                                $sitemap->add($link_images, $university->updated_at, '0.8', 'weekly');
                            }
                        });
        $sitemaps_generated = $sitemap->generate('xml');
        try {
            $sitemap_namefile = $this->genPath('university', 1);
            $disk             = $this->getDisk();
            $disk->put($sitemap_namefile, $sitemaps_generated['content']);
            return true;
        } catch (\Exception $exception) {
            throw new \Exception('Khong luu dc sitemap');
        }
    }

    /**
     * Lấy ra sitemap index cho tất cả các sitemap
     */
    public function getListSitemap($type = '')
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make("sitemap");

        $sitemap_files = $this->getDisk()->listContents($this->rootPath());
        foreach ($sitemap_files as $file) {
            $a_name      = explode('_', $file['filename'], 2);
            $url         = route('sitemap.detail', [
                'type' => $a_name[0],
                'part' => $a_name[1]
            ]);
            $last_modify = $file['timestamp'];
            $sitemap->addSitemap($url, date('Y-m-d H:i:s', $last_modify));
        }
        return $sitemap->generate('sitemapindex');
    }

    /**
     * Lấy nội dung sitemap
     * @param $type
     * @param $part
     * @return string
     */
    public function genSitemapContent($type, $part)
    {
        $file = $this->genPath($type, $part);
        if (!$this->getDisk()->exists($file)) {
            abort(404);
        }
        return $this->getDisk()->get($file);
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getDisk()
    {
        return Storage::disk('public_sitemaps');
    }

    /**
     * Tao duong dan file tu loai sitemap va part
     * @param $type
     * @param $path
     *
     * @return string
     */
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
}