<?php

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../../model/' . $class . '.php';
});

$a = new NewsWeb\Mapping\theimageMapping(['idtheimage'=>1,
    'theimagename'=>'michel.jpg',
    'theimagetype'=>'jpeg',
    'theimageurl'=>'http://newsweb.com/michel.jpg',
    'theimagetext'=>'Michel à la plage',
]);
$b = new NewsWeb\Mapping\theimageMapping([]);
$c = new NewsWeb\Mapping\theimageMapping(['idtheimage'=>'9']);
$d = new NewsWeb\Mapping\theimageMapping(['theimagename'=>'dfgtrsredgdgdgdd try  ftgdfg hgjhjg fghgjh bfgjhtyjj gjhghkjl ghjhgjkuhjk sdfgvhgrjh gfhjtra']);
$e = new NewsWeb\Mapping\theimageMapping(['theimagetype'=>'dfgtrsred']);
$f = new NewsWeb\Mapping\theimageMapping(['theimagetext'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, molestiae possimus eligendi repudiandae quisquam laudantium minus nemo et voluptates assumenda iure at veritatis nihil ad provident, autem asperiores soluta odio velit officiis non, recusandae a praesentium? Repellat tempora earum, praesentium repudiandae dolorum exercitationem modi rerum corrupti officiis odio possimus accusamus pariatur a laborum sunt reprehenderit incidunt id ullam distinctio! Quo consequuntur iusto ipsum cum sit culpa, rem iste veritatis, maiores provident perspiciatis sunt aperiam inventore sequi nesciunt modi adipisci aliquid ducimus deserunt consectetur! Ipsum cumque nemo a. Enim quo reprehenderit illum at modi assumenda sequi labore cum in nisi, ipsum illo architecto ab praesentium quos inventore autem voluptatem aliquid qui! Recusandae cum doloribus delectus perferendis rem quos illum, accusamus, corporis nesciunt beatae doloremque! Alias tempora quaerat in aperiam enim, totam id deserunt eveniet voluptate, iusto, odit consectetur debitis repellendus consequuntur voluptas nihil ad quos est sequi. Quibusdam obcaecati corrupti accusamus dicta libero quaerat deleniti optio quis delectus pariatur neque a, fuga dolores eveniet dolore molestias nam architecto esse aspernatur voluptatum. Accusamus eius fugiat molestias ut eveniet molestiae officiis nobis. Maxime, unde quia odit facere culpa consequatur porro, aperiam quos qui debitis dicta incidunt tenetur, magnam nesciunt pariatur velit. Rem architecto similique nobis dolorum id at, adipisci ipsum, doloribus odio perspiciatis, perferendis deleniti quod veritatis facere laborum vel voluptatum! Accusantium eius distinctio eaque, aut necessitatibus optio. Dicta perferendis nobis corrupti adipisci animi libero voluptates eius officia molestiae, provident excepturi iusto sapiente, obcaecati similique illum quia? Tempora eligendi dignissimos velit laboriosam autem repellendus explicabo, itaque dolor hic vero ex consequuntur minima quas? dfgtrsredgdgdgdd try  ftgdfg hgjhjg fghgjh bfgjhtyjj gjhghkjl ghjhgjkuhjk sdfgvhgrjh gfhjtra'])
?><pre><?php var_dump($a,$b,$c,$d,$e,$f); ?></pre>