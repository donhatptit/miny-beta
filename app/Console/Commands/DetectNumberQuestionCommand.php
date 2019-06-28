<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;
use Vinkla\Hashids\Facades\Hashids;

class DetectNumberQuestionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:question
                            {--option=all : chon all/id cau hoi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect số thứ tự câu hỏi trong từng vòng từ field question';

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
        $option = $this->option('option');
        $regex = '/((?<=Câu\s)|(?<=câu\s))\d+/';
        $this->info('Running.....');
        if ($option == 'all') {
            $questions = Question::all();
            foreach ($questions as $question) {
                $check = preg_match($regex, $question->question, $arr_number);
                if ($check) {
                    $number = array_get($arr_number, 0);
                    $question->number = (int)$number;
                    $question->save();
                }
            }
        } elseif (is_numeric($option)) {
            $question = Question::find($option);
            if (!$question) {
                $this->error('Không có câu hỏi với id bạn đã nhập');
            } else {
                $check = preg_match($regex, $question->question, $arr_number);
                if ($check) {
                    $number = array_get($arr_number, 0);
                    $question->number = (int)$number;
                    $question->save();
                }
            }
        }

    }
}
