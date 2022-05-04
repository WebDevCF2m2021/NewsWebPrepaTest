<?php

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../../model/' . $class . '.php';
});

$a = new NewsWeb\Mapping\thesectionMapping(['idthesection'=>9,
    'thesectiontitle'=>'HTML',
    'thesectionslug'=>'html',
]);
$b = new NewsWeb\Mapping\thesectionMapping([]);
$c = new NewsWeb\Mapping\thesectionMapping(['idthesection'=>'9']);
$d = new NewsWeb\Mapping\thesectionMapping(['tehsectiontitle'=>'dfgtrsre try  ftgdfg hgjhjg fghgjh bfgjhtyjj gjhghkjl ghjhgjkuhjk sdfgvhgrjh gfhjtra']);
?><pre><?php var_dump($a,$b,$c,$d); ?></pre>
