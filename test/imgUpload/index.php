<?php
/*
 * https://packagist.org/packages/verot/class.upload.php
 * https://github.com/verot/class.upload.php/blob/master/README.md
 * https://www.verot.net/php_class_upload_samples.htm
 */

use Verot\Upload\Upload;

// Composer autoload
require_once '../../vendor/autoload.php';

define('IMG_RESIZED',__DIR__.'/images/resized');
define('IMG_RESIZED_CROP',__DIR__.'/images/resizedcrop');
define('IMG_ORIGINAL',__DIR__.'/images/original');

if(isset($_FILES['image_field'])){
    $handle = new Upload($_FILES['image_field']);
    if ($handle->uploaded) {

        $name = date("YmdHis");
        $handle->file_new_name_body   = $name.'image_original';
        $handle->allowed = array('image/*');
        $handle->process(IMG_ORIGINAL);
        $handle->file_new_name_body   = $name.'image_resized_crop';
        $handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->image_y               = 50;
        $handle->image_x               = 50;
        $handle->allowed = array('image/*');
        $handle->process(IMG_RESIZED_CROP);
        $handle->file_new_name_body   = $name.'image_resized';
        $handle->image_resize         = true;
        $handle->image_x              = 100;
        $handle->image_ratio_y        = true;
        $handle->allowed = array('image/*');
        $handle->process(IMG_RESIZED);
        if ($handle->processed) {
            //echo $handle->log;
            echo 'image resized';
            $handle->clean();
        } else {
            echo 'error : ' . $handle->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test d'upload</title>
</head>
<body>
<h1>test d'upload</h1>
<form enctype="multipart/form-data" method="post" action="">
    <input type="file" size="32" name="image_field" value="">
    <input type="submit" name="Submit" value="upload">
</form>
<?= __DIR__ ?>
</body>
</html>
