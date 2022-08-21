<?php

require_once '../Klein.php';

function title($x) {
    return ucfirst($x);
}

$tpl = new Klein('tempalte.html');

echo $tpl->render([
    'pagename' => 'awesome people',
    'authors' => [['name' => 'Paul', 'age' => 10], ['name' => 'Jim', 'age' => 11], ['name' => 'Jane', 'age' => 12]],
    'city'=> [
        'Yaroslaval' => 1,
        'Moscow' => 2
    ]
]);