<?php

namespace App\Console\Commands;

use App\Models\Score;
use App\Models\University;
use App\Models\UniversityAttribute;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;

class GenHtmlScoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tao html bang diem chuan';

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
        $this->info('Running....');
      University::chunk(100, function($universities){
                foreach($universities as $university){
                   $this->renderView($university);
                }
            });
        $this->info('DONE!!!');

    }
    public function renderView($university){
        try{
            $years = Score::where('university_id', $university->id)
                ->groupBy('year')
                ->pluck('year');
            foreach($years as $year){
                $scores = Score::where('year', $year)
                    ->where('university_id', $university->id)
                    ->get(['name', 'code', 'group_subject', 'point', 'note', 'year']);
                if(count($scores) > 0){
                    $viewHandler = \App::make('Illuminate\View\Factory');
                    $rendered = $viewHandler->make('frontend.admissions.university.table_score', ['scores' => $scores, 'university' => $university, 'year'=> $year, 'years' => $years]);
                    $text = $rendered->render();
                    $check = UniversityAttribute::where('university_id', $university->id)
                        ->where('type', UniversityAttribute::DIEM_CHUAN)
                        ->where('year', $year)
                        ->first();
                    if(empty($check)){
                        UniversityAttribute::create([
                            'title' => "Điểm chuẩn $university->vi_name năm $year",
                            'content' => $text,
                            'type' => UniversityAttribute::DIEM_CHUAN,
                            'university_id' => $university->id,
                            'year' => $year,
                            'created_by' => 1,
                            'is_handle' => UniversityAttribute::FINISH,
                        ]);
                    }
                }
            }
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }

    }
}
