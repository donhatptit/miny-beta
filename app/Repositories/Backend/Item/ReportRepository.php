<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 08/08/2018
 * Time: 08:54
 */

namespace App\Repositories\Backend\Item;


use App\Report;
use App\Repositories\BaseRepository;

class ReportRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Report::class;
    }
}