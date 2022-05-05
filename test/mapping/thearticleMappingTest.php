<?php
spl_autoload_register(function ($class) {
    include_once '../../model/' . $class . '.php';
});

$a = new NewsWeb\Mapping\thearticleMapping([]);

echo"<pre>";
// utilisation du trait utilisé dans NewsWeb\Mapping\thearticleMapping qui est une méthode static , donc qui permet d'être utilisée sans instanciations
echo $a::slugify("Je veux transformer ce texte en slug"); // sur l'instance
echo "<br>".NewsWeb\Mapping\thearticleMapping::slugify("L'école ça n'apporte rien"); // sur la classe
var_dump($a);
echo "</pre>";