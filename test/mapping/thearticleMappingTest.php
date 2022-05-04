<?php

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../../model/' . $class . '.php';
});

$a = new NewsWeb\Mapping\thearticleMapping(['idthearticle'=>4,
    'thearticletitle'=>'Article Title',
    'thearticleslug'=>'Article Slug', 
    'thearticleresume'=>'Article Resume',
    'thearticletext'=>'lulu',
    'thearticledate'=>'DATE/TIME',
    'thearticleactivate'=>1,
]);
$b = new NewsWeb\Mapping\thearticleMapping([]);
$c = new NewsWeb\Mapping\thearticleMapping(['idthearticle'=>'5']);
$d = new NewsWeb\Mapping\thearticleMapping(['thearticletitle'=>'Le Lorem Ipsum']);
$e = new NewsWeb\Mapping\thearticleMapping(['thearticleslug'=>'Lorem OK Lorem OK']);
$f = new NewsWeb\Mapping\thearticleMapping(['thearticletext'=>"Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker."]);
$g = new NewsWeb\Mapping\thearticleMapping(['thearticledate'=>'DATE/TIME']);
$h = new NewsWeb\Mapping\thearticleMapping(['thearticleactivate'=>1]);


?><pre><?php var_dump($a,$b,$c,$d,$e,$f,$g,$h); ?></pre>


