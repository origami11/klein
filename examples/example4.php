<?php

require_once '../Klein.php';

function title($x) {
    return ucfirst($x);
}

$tpl = new Klein('template.html');

$u1 = new stdClass();
$u1->name = 'Paul';
$u1->age = 10;

$u2 = new stdClass();
$u2->name = 'Jim';
$u2->age = 11;

$u3 = new stdClass();
$u3->name = 'Jane';
$u3->age = 12;

echo $tpl->render([
    'pagename' => 'awesome people',
    'authors' => [$u1, $u2, $u3],
    'city'=> [
        'Yaroslaval' => 1,
        'Moscow' => 2
    ]
]);