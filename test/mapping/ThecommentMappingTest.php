<?php



// Personal autoload

spl_autoload_register(function ($class) {

    include_once '../../model/' . $class . '.php';

});



$a = new NewsWeb\Mapping\thecommentMapping(['idthecomment'=>5,

    'theuser_idtheuser'=>'lulu',

    'thecommenttext'=>"a1a2a3a4",

    'thecommentdate'=> 'date()',

    'thecommentactive'=>33,

   



]);

$b = new NewsWeb\Mapping\thecommentMapping([]);

$c = new NewsWeb\Mapping\thecommentMapping(['idthecomment'=>'999999999999']);

$d = new NewsWeb\Mapping\thecommentMapping(['theuser_idtheuser'=>'dfgtrsre try  ftgdfg hgjhjg fghgjh bfgjhtyjj gjhghkjl ghjhgjkuhjk sdfgvhgrjh gfhjtra']);

$e = new NewsWeb\Mapping\thecommentMapping(['thecommenttext'=>'9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999']);

$f = new NewsWeb\Mapping\thecommentMapping(['thecommentdate'=>'aaaa@gmail.com']);

$g = new NewsWeb\Mapping\thecommentMapping(['thecommentactive'=>'aaaa@gmail.com']);




?><pre><?php var_dump($a,$b,$c,$d,$e,$f,$g); ?></pre>