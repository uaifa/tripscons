<?php
namespace App\Libs\Image;

use \Image;
use Intervention\Image\ImageManager;

class Optimizer {

    public static function optimize($image) {
        $file = \File::get($image);
        $manager = new ImageManager();
        $imageObj = $manager->make($file)->resize(640, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbImageObj = $manager->make($file)->resize(320, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        unlink($image);
        $imageObj->save($image, 90, 'jpg');
        $thumbImageObj->save($image.'_thumb.jpg', 90, 'jpg');
    }

}
