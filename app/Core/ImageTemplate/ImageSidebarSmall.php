<?php
/**
 * Created by PhpStorm.
 * User: huyptit
 * Date: 27/02/2019
 * Time: 16:33
 */

namespace App\Core\ImageTemplate;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ImageSidebarSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(139, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
}