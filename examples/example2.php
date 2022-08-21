<?php

$data = [
	[
    	'id' => 0,
    	'id_table' => 0,
    	'name' => '',
	    'header' => 'Header #1',
    	'comment' => '',
       	'colspan' => 0,
    	'rowspan' => 4,
    	'row' => 0,
    	'position' => 0,
    	'type' => '',
    ],
	[
	    'id' => 1,
       	'id_table' => 0,
        'name' => '',
    	'header' => '',
    	'comment' => 'Header #2',
    	'rowspan' => 0,
    	'row' => 0,
    	'position' => 1,
    	'type' => '',
    ]
];


require_once '../Klein.php';

$tpl = new Klein('template2.html');

echo $tpl->render(['content' => $data]);
