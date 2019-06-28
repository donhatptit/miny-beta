<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Question;
use App\Models\QuestionCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class QuestionController extends FrontendController
{
    public function index(Request $request, $code,$slug){
            if(Auth::check()){
                $question_category = QuestionCategory::where('code',$code)->first();
            }else{
                $question_category = QuestionCategory::where('code',$code)->where('is_approve',1)->first();
            }
            if(!$question_category){
                abort(404);
            }
            $title_right = '';
            $title_content = '';
            // danh muc goc
            if($question_category->isRoot()){
               $seo_title = "Tổng hợp câu hỏi ". $question_category->name;

               $seo_description = "Câu hỏi " . $question_category->name . " đầy đủ, chi tiết. Tổng hợp các câu hỏi " .  $question_category->name . " qua các tập. Cập nhật các câu hỏi " . $question_category->name . " nhanh nhất.";
               $seo_keyword = [
                   $question_category->name, "câu hỏi ".  $question_category->name,
                   "những tập mới"," chương trình giải trí",
                   "toàn bộ các câu hỏi", "chương trình ".  $question_category->name ,
                   "cập nhật nhanh nhất"
               ];

               $data['first_content'] = "<b>" .  $question_category->name . "</b> đang là chương trình giải trí có lượng theo dõi lớn nhất hiện nay. <b>Cunghocvui</b> đã tổng hợp và liệt kê hết lại các câu hỏi <b> ".  $question_category->name ." </b> từng tập một, luôn cập nhật nhanh nhất những tập mới, giúp bạn có thể trải nghiệm những Câu hỏi " . $question_category->name . " như đang tham gia chương trình";

               $data['end_content'] = "Toàn bộ các câu hỏi <b>" . $question_category->name. "</b> được <b>Cunghocvui</b> tổng hợp lại theo từng tuần sau mỗi số mới của chương trình <b>" . $question_category->name . "</b>. Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!";

//               $list_category = $question_category->getImmediateDescendants()->sortBy('lft');
               $list_category = QuestionCategory::where('parent_id', $question_category->id)->where('is_approve', QuestionCategory::APPROVED)->orderBy('lft')->get();
                $data['title'] = $question_category->name . " - Tổng hợp các câu hỏi " . $question_category->name;
                $title_content = $question_category->name .' - ';

                // cac vong choi

            }elseif($question_category->depth == 2){

                $category_parent = $question_category->parent()->first();
                $cate_root =  $question_category->getRoot();

                $seo_title = "Tổng hợp câu hỏi " .$question_category->name .  " - " . $category_parent->name . " - Nhanh như chớp, " . $question_category->player;
                $seo_keyword = [
                    $cate_root->name. " " .$category_parent->name ." ". $question_category->name,
                    "tổng hợp câu hỏi",$question_category->player,
                    "đầy đủ nhất", "có đáp án đầy đủ và chi tiết",
                    "cuộc đua gay cấn"
                ];

                $seo_description = "Toàn bộ các câu hỏi " . $question_category->name . " - " . $category_parent->name . " - " . $cate_root->name .". Các câu hỏi giữa " .$question_category->player . ", có đáp án đầy đủ và chi tiết. Tổng hợp các câu hỏi " . $question_category->name  . " - " . $category_parent->name .  " - " .$cate_root->name. " " . $question_category->player;

                $data['first_content'] = "Cùng trải nghiệm những Câu hỏi <b>" . $question_category->name . " - " . $category_parent->name . " - ". $cate_root->name. "</b>, cuộc đua gay cấn giữa <b><i>" . $question_category->player .  "</i></b> Thử sức xem bạn sẽ trả lời được bao nhiêu câu nhé!";
                $data['end_content'] = "Tổng hợp toàn bộ các câu hỏi <b>" . $cate_root->name . " - " . $category_parent->name . " - " . $question_category ->name . "</b>, " . " <b><i>" . $question_category->player .  "</i></b>" . "<br>" . " Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!";

                $list_category = $question_category->questions;
                $data['title'] = $cate_root->name . " - Tổng hợp câu hỏi " . $question_category->name . " - " . $category_parent->name . " - " .$cate_root->name. ", ". $question_category->player;

                $title_right = $cate_root->name . " - " . $category_parent->name . " - ";
            // Tap choi
            }else{
                $cate_root = $question_category->getRoot();
                $category_parent = $question_category->parent()->first();
                $seo_title = "Tổng hợp các câu hỏi " . $cate_root->name . " " . $question_category->name . " đầy đủ nhất";
                $seo_description = "Toàn bộ các câu hỏi " . $cate_root->name ." " . $question_category->name . ". Câu hỏi " . $cate_root->name . " " . $question_category->name . " đầy đủ, chi tiết nhất. Tổng hợp các câu hỏi " . $cate_root->name . " " . $question_category->name . " có đáp án.";
                $seo_keyword = [
                    $cate_root->name . " " . $question_category->name ,
                    "câu hỏi " . $cate_root->name . " " . $question_category->name ,
                    "toàn bộ các câu hỏi", "từng vòng chơi", "người chơi cụ thể",
                    "có đáp án", "đầy đủ", "chi tiết nhất"
                ];

                $data['first_content'] = "Bắt kịp xu hướng bằng các câu hỏi <b>". $cate_root->name ."</b>. Câu hỏi <b>" . $cate_root->name . " " . $question_category->name . "</b> được <i>Cunghocvui</i> tổng hợp lại theo từng vòng chơi, người chơi cụ thể. Cùng trải nghiệm các câu hỏi <b>". $cate_root->name . " " . $question_category->name . "</b> để xem bạn thông minh đến đâu nhé! ";

                $data['end_content'] = "Toàn bộ các câu hỏi <b>" . $cate_root->name . " " . $question_category->name . "</b> được <i>Cunghocvui</i> tổng hợp và phân loại riêng theo từng vòng riêng biệt. Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!";
                $list_category = QuestionCategory::where('parent_id', $question_category->id)->where('is_approve', QuestionCategory::APPROVED)->orderBy('lft')->get();



                $data['title'] = "Câu hỏi " . $cate_root->name . " " . $question_category->name .  " - Tổng hợp các câu hỏi " . $cate_root->name . " " . $question_category->name .  " đầy đủ nhất";

                $itle_right = $cate_root->name . " - ";
                $title_content = $cate_root->name. " - " . $question_category->name . " - " ;


            }
            $this->setSeoMeta($seo_title,$seo_description,$seo_keyword);
            if ($question_category->is_public == Question::GOOGLE_INDEX){
                $this->setIndexSEO(true);
            }else{

                $this->setIndexSEO(false);
            }

            $data['list_category_right'] = $question_category->getSiblings()->take(10);
            $data['current_category'] = $question_category;
            $data['title_right'] = $title_right;
            $data['list_category'] = $list_category;
            $data['title_content'] = $title_content;
        return view('frontend.questions.index',$data);
    }

    public function detail(Request $request, $code, $slug){
        $question = Question::where('code',$code)->first();
        if(Auth::check()){
            $category = QuestionCategory::where('id',$question->category_id)->first();
        }else{
            $category = QuestionCategory::where('id',$question->category_id)->where('is_approve',1)->first();
        }
        if(!$question || !$category){
            abort(404);
        }
        $current_category = QuestionCategory::find($question->category_id);
        $data['question_next'] = $this->getQuestionNext($question, $question->number);
        $data['question_preview'] = $this->getQuestionPreview($question, $question->number);
        $cate_root = $current_category->getRoot();
        $category_parent = QuestionCategory::find($current_category->parent_id);
        $data['title'] = $question->question . " - " . $cate_root->name . " " . $category_parent->name . " - " . $current_category->name;
        $data['more_question'] = Question::where('category_id',$question->category_id)->where('code','<>',$code)->get();
        $data['question'] = $question;
        $data['current_category'] = $current_category;
        $seo_title = $data['title'];
        $seo_description = $question->question . " - " . $cate_root->name . " " . $category_parent->name . " - " . $current_category->name . " - " . $current_category->player . ". Các câu hỏi " . $cate_root->name . " được cập nhật nhanh và đầy đủ nhất tại Cunghocvui.";
        $seo_keyword = [
            $question->question, $cate_root->name . " " . $category_parent->name . " " .$current_category->name,
            $current_category->player, "cuộc đối đầu", "cập nhật nhanh và đầy đủ nhất", "Câu hỏi ". $cate_root->name
        ];
        $this->setSeoMeta($seo_title, $seo_description, $seo_keyword);

        if ($category->is_public == QuestionCategory::GOOGLE_INDEX){
            $this->setIndexSEO(true);
        }else{

            $this->setIndexSEO(false);
        }
        return view('frontend.questions.index2',$data);
    }

    public function storeStatus(Request $request){
        $result = [
            'title' => 'Thất bại',
            'message' => 'Không thể lưu trạng thái bài viết '
        ];
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->isAdmin();
            // kiem tra co phai quyen admin khong
            if ($role) {
                try {

                    $is_public = $request->is_public;
                    $is_approve = $request->is_approve;
                    $id_question = $request->id_question;
                    $question = QuestionCategory::find($request->id_cate);
                    if (!$question) {
                        abort(404);
                    }
                    $question->is_public = $is_public;
                    $question->is_approve = $is_approve;
                    if ($is_approve == 1) {
                        $time_approve = Carbon::now();
                        $question->approved_at = $time_approve;
                    }
                    if (isset($request->reason)) {
                        $question->unapprove_reason = $request->reason;
                    }

                    $question->save();
                    if ($question) {
                        $result['title'] = 'Thành công';
                        $result['message'] = 'Trạng thái bài viết <b>' . $question->question . '</b> được cập nhật thành công';
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        return $result;
    }
    public function getQuestionPreview(Question $question, $number_current){
        if (empty($number_current)){
            return null;
        }
        $number = $number_current - 1;
        if($number == 0){
            return null;
        }
        $question_pre = Question::where('category_id', $question->category_id)->where('number', $number)->first();
        if(isset($question_pre)){
            return $question_pre;
        }else{
            return $this->getQuestionPreview($question,$number);
        }
        return null;

    }
    public function getQuestionNext(Question $question, $number_current){
        if (empty($number_current)){
            return null;
        }
        $number = $number_current + 1;
        $count_question = Question::where('category_id', $question->category_id)->select('id')->count();
        if($number > $count_question){
            return null;
        }
        $question_pre = Question::where('category_id', $question->category_id)->where('number', $number)->first();
        if(isset($question_pre)){
            return $question_pre;
        }else{
            return $this->getQuestionNext($question,$number);
        }
        return null;
    }
}
