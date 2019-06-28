<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Repositories\Backend\Item\CategoryRepository;
use App\User;
use Baum\Node;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    const LIST_INDENT = "=== ";
    /**
     * ProfileController constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request){
        $data['count_post_approve'] = 0;
        $data['count_post'] = 0;

        $root_categories = \Cache::remember('dashboard_root_categories', 60, function (){
            return $this->categoryRepository->getRootCategory();
        });

        foreach ($root_categories as $category){
            $data['count_post_approve'] += $category->num_approved_posts;
            $data['count_post'] += $category->num_posts;
        }

        $data['count_user'] = \Cache::remember('dashboard_count_user', 60, function (){
            return User::count();
        });
        $data['new_post'] = Post::with(['user' => function($query) {
            $query->select(['id', 'name']);
        }])
            ->orderBy('created_at','desc')->take(10)
            ->select(['id', 'slug', 'title', 'is_approve', 'created_at', 'created_by'])->get();

        $data['categories_question'] = QuestionCategory::where('depth', 0)->select(['id', 'name'])->get();

        // Lấy ra số bài viết của user đã nhập liệu được
        $date= explode(' / ', $request->date_option);
        if(count($date) < 2){
            $date[0] = Carbon::minValue();
            $date[1] =  Carbon::now();
        }
        $start_day = Carbon::parse($date[0])->startOfDay();
        $end_day = Carbon::parse($date[1])->endOfDay();
        $data['date_view'] = $request->date_view;

        $data['categories'] = \Cache::remember('dashboard_count_categories', 60, function (){
            return Category::where('depth',1)->select(['id', 'name'])->get();
        });

        $user_post = \Cache::remember('dashboard_user_post', 60, function (){
            return DB::table('users')
                ->select('users.id', 'users.name')
                ->join('role_users','role_users.user_id','=','users.id')
                ->where('role_users.role_id', '>', 0)
                ->get();
        });
        foreach ($user_post as $user){
            $approve  = Post::where('is_approve', 1)
                            ->where('created_by', $user->id)
                            ->where('created_at','>', $start_day)
                            ->where('created_at','<', $end_day);

            $not_approve = Post::where('is_approve', 0)
                            ->where('created_by', $user->id)
                            ->where('created_at', '>', $start_day)
                            ->where('created_at', '<', $end_day);
            if($request->category !== null){
                $descendant_ids = $this->getAllDescendantsId($request->category);

                $user->count_approve = $approve->whereIn('category_id', $descendant_ids)->count();
                $user->count_not_approve = $not_approve->whereIn('category_id', $descendant_ids)->count();
            }else{
                $user->count_approve = $approve->count();
                $user->count_not_approve = $not_approve->count();
            }
        }

        // Thống kê nhập liệu phần câu hỏi : nhanh như chớp
        /**
         * Lấy ra số lượng các tập va so luong cau hoi
         *
         */
        $cate_question = \Cache::remember('dashboard_count_categories', 60, function (){
            return QuestionCategory::where('depth',1)->get();
        });
        $count_question = 0;
        if($request->category_question !== null){
            $data['cate_question_approve'] = $cate_question->where('parent_id',$request->category_question)->where('is_approve',1)->count();
            $data['cate_question_not_approve'] = $cate_question->where('parent_id',$request->category_question)->where('is_approve',0)->count();
            $categoriess = QuestionCategory::find($request->category_question)->getLeaves();
            foreach ($categoriess as $category){
                $count_question = $count_question + Question::where('category_id',$category->id)->count();
            }
            $data['count_flash_question'] = $count_question;



        }else{
            $data['cate_question_approve'] = $cate_question->where('is_approve',1)->count();
            $data['cate_question_not_approve'] = $cate_question->where('is_approve',0)->count();
                    $data['count_flash_question'] = Question::all()->count();
        }
        $data['count_post_user'] = $user_post->sortByDesc('count_approve');

        return view('vendor.backpack.base.dashboard',$data);


    }

    public function getAllDescendantsId($cate_id){
        $root_cate = $this->categoryRepository->getById($cate_id);
        if(!$root_cate) return [$cate_id];

        /** @var $root_cate Node*/
        $descendants = $root_cate->getDescendantsAndSelf()->toArray();
        $descendant_ids = [];
        foreach ($descendants as $descendant){
            $descendant_ids[] = $descendant['id'];
        }

        return $descendant_ids;
    }
}
