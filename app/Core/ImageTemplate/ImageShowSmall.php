<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 27/02/2019
 * Time: 16:31
 */

namespace App\Core\ImageTemplate;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ImageShowSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(220, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

}