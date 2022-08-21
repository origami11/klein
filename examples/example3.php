<?php

$data = ['phedor', 'andrey'];

require_once '../Klein.php';

$tpl = new Klein('template3.html');

echo $tpl->render(['names' => $data]);
