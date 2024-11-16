<?php
require_once 'libs/Database.class.php';

$params		= [
	'server' 	=> 'localhost',
	'username'	=> 'root',
	'password'	=> '',
	'database'	=> 'zend_rss',
	'table'		=> 'rss',
];

$database = new Database($params);
