<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;

class RenderDescriptionCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'description:run
                            {--type=class :class/formula/youknow}
                            {--option=class :class/subject/lesson}';

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
        $type = $this->option('type');
        $option = $this->option('option');
        if($type == 'class'){
            $cate_ori = Category::where('slug','LIKE','lop-%')->get();
        }elseif($type == 'formula'){
            $cate_ori = Category::where('slug','cong-thuc')->get();
        }elseif($type == 'youknow'){
            $cate_ori = Category::where('slug','ban-co-biet')->get();
        }

        if($option == 'class'){
            $this->info('Running class .....');
            foreach($cate_ori as $cate){
                $seo = $this->renderSeo($type,$option,$cate);
                $cate->description_top = $this->renderDescriptionTop($type,$option,$cate);
                $cate->description_bottom = $this->renderDescriptionBottom($type,$option,$cate);
                $cate->seo_title = $seo['title'];
                $cate->seo_description = $seo['title'];
                $cate->save();
            }
        }
        if($option == 'subject'){
            $this->info('Running subject ...');
            foreach($cate_ori as $cate){
                foreach($cate->getImmediateDescendants() as $subject){
                    $seo = $this->renderSeo($type,$option,$subject);
                    dump($seo);
                    $subject->description_top = $this->renderDescriptionTop($type,$option,$subject);
                    $subject->description_bottom = $this->renderDescriptionBottom($type,$option,$subject);
                    $subject->seo_title = $seo['title'];
                    $subject->seo_description = $seo['title'];
                    $subject->save();
                }
            }
        }
        if($option == 'lesson'){
            $this->info('Running lesson ...');
            foreach($cate_ori as $cate){
                $categories = $cate->getLeaves();
                if(!$categories) continue;
                foreach($categories as $lesson){
                    $category_subject = $lesson->getCategorySubject();
                    if(!$category_subject) continue;
                    if(preg_match('/(^ngu-van|^tieng-viet)/', $category_subject->slug, $matches)){
                        $seo = $this->renderSeo($type,$option,$lesson,'ngu-van');
                        $lesson->description_top = $this->renderDescriptionTop($type,$option,$lesson,'ngu-van');
                        $lesson->description_bottom = $this->renderDescriptionBottom($type,$option,$lesson,'ngu-van');
                        $lesson->seo_title = $seo['title'];
                        $lesson->seo_description = $seo['description'];
                    }else{
                        $seo = $this->renderSeo($type,$option,$lesson);
                        $lesson->seo_title = $seo['title'];
                        $lesson->seo_description = $seo['description'];
                        $lesson->description_top = $this->renderDescriptionTop($type,$option,$lesson);
                        $lesson->description_bottom = $this->renderDescriptionBottom($type,$option,$lesson);
                    }
                    $lesson->save();
                }
            }
        }

    }

    public function renderDescriptionTop($type, $option, $category, $extra = null){
        // type = 'class' or 'orther'
        // option = 'class','subject','lesson';
        $text = "";
        if($type == 'class'){
            switch ($option){
                case 'class' :
                    $text = "Để giúp việc học tập không còn là nỗi lo với các em học sinh, Cunghocvui đã tổng hợp và hệ thống lại toàn bộ các lời giải hay và đầy đủ nhất của tất cả các môn học trong chương trình <b>" . $category->name ."</b>. Lời giải của chúng tôi bám sát với chương trình học <b>". $category->name . "</b> của Bộ Giáo dục và Đào tạo đưa ra.";
                    break;
                case 'subject' :
                    $text = "Giải bài tập <b>" . $category->name . "</b> chính là cẩm nang giúp các em học tốt môn <b>" . $category->name . "</b>. Với hệ thống các lời giải theo các cách khác nhau cho từng bài tập trong Sách giáo khoa <b>" . $category->name . "</b>, Cunghocvui hi vọng sẽ là sổ tay học tập tốt nhất cho các em học sinh sử dụng trong quá trình học tập. Dưới đây là mục lục theo đúng chương trình học trong Sách giáo khoa <b>" . $category->name . "</b>, mời các em theo dõi.";
                    break;
                case 'lesson' :
                    if($extra == 'ngu-van'){
                        $text = "Tổng hợp các bài soạn văn với độ dài bài soạn đa dạng về tác phẩm <b>" . $category->name . "</b>. Các bài phân tích, nghị luận, bình giảng và suy nghĩ về tác phẩm <b>" . $category->name . "</b>. Mời các em cùng theo dõi nhé!";
                    }else{
                        $text = "Tổng hợp các bài giải bài tập trong <b>" . $category->name . "</b> được biên
                    soạn bám sát theo chương trình Đào tạo của Bộ Giáo dục và Đào tạo. Các em cùng theo dõi nhé!";
                    }

                    break;
            }

        }elseif($type == 'formula'){
            switch ($option){
                case 'class' :
                    $text = "Hệ thống <b>" . $category->name . "</b> của từng môn học. Cunghocvui đã sưu tầm và tổng hợp lại được <b>" . $category->name . "</b> của một số bộ môn. Mời các em theo dõi nhé";
                    break;
                case 'subject' :
                    $text = "Hệ thống <b>" . $category->name . "</b> được Cunghocvui tổng hợp theo từng chủ đề riêng biệt. Dưới đây là mục lục các <b>" . $category->name . "</b>, các bạn cùng theo dõi nhé!";
                    break;
                case 'lesson' :
                    $text = "Tổng hợp đầy đủ các <b>" . $category->name . "</b> được học trong chương trình học. Công thức các góc trong tam giác, Công thức góc chia đôi, Các công thức hạ bậc,... cùng nhiều công thức khác nằm trong phần <b>" . $category->name . "</b>. ";
                    break;
            }
        }elseif($type == 'youknow'){
            switch ($option){
                case 'class' :
                    $text = "Các mẹo học tập được Cunghocvui tổng hợp lại theo từng lĩnh vực dưới đây. Mời các bạn cùng theo dõi nhé";
                    break;
                case 'subject' :
                    $text = "Các <b>" . $category->name . "</b> hay ho nhất được Cunghocvui biên soạn, sưu tầm và tổng hợp lại đầy đủ.<br> Hi vọng sẽ đem lại những kiến thức hữu íchnhất cho các em học sinh. Mời các em cùng theo dõi nhé";
                    break;
                case 'lesson' :
                    $text = "Các <b>" . $category->name . "</b> hay ho nhất được Cunghocvui biên soạn, sưu tầm và tổng hợp lại đầy đủ.<br> Hi vọng sẽ đem lại những kiến thức hữu íchnhất cho các em học sinh. Mời các em cùng theo dõi nhé";
                    break;
            }
        }

        return $text;
    }
    public function renderDescriptionBottom($type,$option,$category, $extra = null){
        // type = 'class' or 'orther'
        // option = 'class','subject','lesson';
        $text = "";
        if($type == 'class'){
            switch ($option){
                case 'class' :
                    $text = "Trên đây là toàn bộ các môn mà các em học sinh sẽ được học trong chương trình học <b>" . $category->name . "</b>.<br>
                        Hi vọng những kiến thức mà Cunghocvui đem lại sẽ hữu ích với các em.<br>
                        Chúc các em học tập và đạt thành tích cao!<br>
                        Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'subject' :
                    $text = "Loạt giải bài tập <b>" . $category->name . "</b> trên đây sẽ giúp các em đạt được kết quả học tập cao nhất.<br>Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'lesson' :
                    if($extra == 'ngu-van'){
                        $text = "Loạt soạn văn, phân tích tác phẩm <b>" . $category->name . "</b> trên đây được Cunghocvui biên tập và sưu tầm lại. Rất mong sẽ đem đến lượng kiến thức bổ ích nhất cho các em học sinh.<br>
Chúc các em học tập và đạt kết quả tốt trong học tập!<br>
Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!";
                    }else{
                        $text = "Trên đây là hệ thống lời giải các bài tập trong <b>" . $category->name . " - " . $category->getCategorySubject()->name . "</b> đầy đủ và chi tiết nhất.<br>Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    }

                    break;
            }

        }elseif($type == 'formula'){
            switch ($option){
                case 'class' :
                    $text = "Trên đây là toàn bộ <b>" . $category->name . "</b> các môn mà Cunghocvui tổng hợp lại được<br>
Hi vọng những kiến thức mà Cunghocvui đem lại sẽ hữu ích với các em.<br> 
Chúc các em học tập và đạt thành tích cao!<br>
Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'subject' :
                    $text = "Trên đây là toàn bộ <b>" . $category->name . "</b> các môn mà Cunghocvui tổng hợp lại được<br>
Hi vọng những kiến thức mà Cunghocvui đem lại sẽ hữu ích với các em.<br> 
Chúc các em học tập và đạt thành tích cao!<br>
Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'lesson' :
                    $text = "Loạt <b>" . $category->name . "</b> trên đây hi vọng sẽ đem lại cho các em kiến thức hữu ích nhất.<br>
Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
            }
        }elseif($type == 'youknow'){
            switch ($option){
                case 'class' :
                    $text = "Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'subject' :
                    $text = "Loạt <b>" . $category->name . "</b> trên đây hi vọng sẽ là bí kíp giúp các em học tập một cách dễ dàng.<br>Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
                case 'lesson' :
                    $text = "Loạt <b>" . $category->name . "</b> trên đây hi vọng sẽ là bí kíp giúp các em học tập một cách dễ dàng.<br>Nếu thấy hay, hãy chia sẻ và ủng hộ nhé!";
                    break;
            }
        }

        return $text;
    }
    public function renderSeo($type,$option,$category, $extra = null){
        $seo = [
            'title' => '',
            'description' => ''
        ];
        // type = 'class' or 'orther'
        // option = 'class','subject','lesson';
        $text = "";
        if($type == 'class'){
            switch ($option){
                case 'class' :
                    $seo['title'] = $category->name .  " | Giải chi tiết toàn bộ bài tập các môn học " . $category->name;
                    $seo['description'] = "Hệ thống lời giải các bài tập của toàn bộ môn học "  . $category->name . ",sắp xếp theo đúng chương trình học chuẩn của Bộ Giáo dục và Đào tạo " . $category->name . ". Tổng hợp, sưu tầm những câu trả lời hay và đầy đủ nhất, giúp em đạt kết quả cao trong quá trình học tập " . $category->name;
                    break;
                case 'subject' :
                    $seo['title'] = $category->name . " | Giải chi tiết toàn bộ bài tập các môn học " . $category->name . " | Giúp em học tốt " . $category->name;
                    $seo['description'] = "Hệ thống các bài giải " . $category->name . ".Tổng hợp các bài giải chi tiết, ngắn gọn và đầy đủ nhất. Lời giải bài tập " . $category->name . " được biên soạn và sưu tầm theo nhiều cách giải khác nhau.";
                    break;
                case 'lesson' :
                    if($extra !== 'ngu-van'){
                        $seo['title'] = "Giải bài tập" . " - " . $category->name . " - " . $category->getCategorySubject()->name;
                        $seo['description'] = "Giải bài tập " . $category->getCategorySubject()->name ." - " . $category->name . ". Hệ thống đầy đủ các bài giải bài tập " . $category->getCategorySubject()->name. " chi tiết và đầy đủ nhất, bám sát chương trình Đào tạo của Bộ Giáo dục và Đào tạo. ";
                    }else{
                        $seo['title'] = "Soạn văn, phân tích tác phẩm: " . $category->name ." (Ngắn gọn nhất)";
                        $posts = Post::where('category_id',$category->id)->limit(3)->get();
                        $count_word = [];
                        foreach($posts as $post){
                            $count_word[] = str_word_count($post->content);
                        }
                        sort($count_word);
                        $text ='';
                        foreach($count_word as $word){
                            $text .= $word . ' từ, ';
                        }
                        $seo['description'] = "Soạn bài " . $category->name. " (Ngắn gọn nhất) với bài soạn dài " . $text . ".... Phân tích, bình giảng, nêu cảm nhận, suy nghĩ về tác phẩm " . $category->name;
                    }

            }

        }elseif($type == 'formula'){
            switch ($option){
                case 'class' :
                    $seo['title'] = "Công thức hay | Tổng hợp công thức Toán, Lí, Hóa quan trọng cần nhớ";
                    $seo['description'] = "Công thức hay, Tổng hợp công thức Toán, Lí, Hóa quan trọng cần nhớ- Cung cấp đầy đủ các công thức hữu ích, cần sử dụng trong quá trình học tập, sử dụng nhiều trong các bài thi quốc gia.";
                    break;
                case 'subject' :
                    $seo['title'] = $category->name . " | " . $category->name . "hay nhất | Tổng hợp " .$category->name ." đầy đủ nhất";
                    $seo['description'] = $category->name . " | " . $category->name . " hay nhất | Tổng hợp" . $category->name . " đầy đủ nhất";
                    break;
                case 'lesson' :
                    $seo['title'] = "Tổng hợp " . $category->name . "đầy đủ, chi tiết nhất";
                    $posts = Post::where('category_id',$category->id)->limit(3)->get();
                    $text = '';
                    foreach($posts as $post){
                        $text .= $post->title . ', ';
                    }
                    $seo['description'] = "Tổng hợp đầy đủ các " . $category->name . " được học trong chương trình học." . $text . "...cùng nhiều công thức khác nằm trong phần Công thức lượng giác.";
            }


        }elseif($type == 'youknow') {
            switch ($option) {
                case 'class' :
                    $seo['title'] = "Bạn có biết - Tổng hợp các mẹo học tập hữu ích nhất";
                    $seo['description'] = "Mẹo nhớ Công thức lượng giác, mẹo nhớ từ vựng Tiếng Anh, Mẹo học thuộc Bảng hoạt động của kim loại,.. Tại chuyên mục Bạn có biết, Cunghocvui sẽ cung cấp cho các bạn những mẹo học tập hữu ích nhất";
                    break;
                case 'subject' :
                    $seo['title'] = $category->name ." - Bí kíp học tập hay nhất";
                    $posts = Post::where('category_id', $category->id)->limit(2)->get();
                    $text = '';
                    foreach ($posts as $post) {
                        $text .= $post->title . ', ';
                    }
                    $seo['description'] = "Hệ thống toàn bộ các " . $category->name . " giúp các em học sinh học tập dễ dàng, bớt nhàm chán hơn " . $text . "...hi vọng sẽ giúp các em học tập hiệu quả hơn.";
                    break;
                case 'lesson' :
                    $seo['title'] = $category->name ." - Bí kíp học tập hay nhất";
                    $posts = Post::where('category_id', $category->id)->limit(2)->get();
                    $text = '';
                    foreach ($posts as $post) {
                        $text .= $post->title . ', ';
                    }
                    $seo['description'] = "Hệ thống toàn bộ các " . $category->name . " giúp các em học sinh học tập dễ dàng, bớt nhàm chán hơn " . $text . "...hi vọng sẽ giúp các em học tập hiệu quả hơn.";
                    break;
            }
        }

        return $seo;
    }
}
