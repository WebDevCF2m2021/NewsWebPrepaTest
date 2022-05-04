<?php

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../../model/' . $class . '.php';
});

$a = new NewsWeb\Mapping\theimageMapping(['idpermission'=>5,
    'permissionname'=>'lulu',
    'permissionrole'=>0,
]);
$b = new NewsWeb\Mapping\theimageMapping([]);
$c = new NewsWeb\Mapping\theimageMapping(['idpermission'=>'5']);
$d = new NewsWeb\Mapping\theimageMapping(['permissionname'=>'dfgtrsre try  ftgdfg hgjhjg fghgjh bfgjhtyjj gjhghkjl ghjhgjkuhjk sdfgvhgrjh gfhjtra']);
?><pre><?php var_dump($a,$b,$c,$d); ?></pre>

