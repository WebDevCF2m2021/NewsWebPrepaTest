<?php
require_once "../model/NewsWeb/Trait/SlugifyTrait.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Slugify-meeeeeeeeeeeeeeee</h1>
<form action="" method="post" name="lulu">
    <input type="text" name="toslug" size="40">
    <input type="submit" value="slug me too much">
    <?php
    if(isset($_POST['toslug'])):
    ?>
    <textarea rows="15" cols="30"><?=\NewsWeb\Trait\SlugifyTrait::slugify($_POST['toslug'])?></textarea>
    <?php
    endif;
    ?>
</form>
</body>
</html>

