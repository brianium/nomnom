<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
if(!defined('FIXTURES'))
    define('FIXTURES', __DIR__ . DS . 'fixtures');

$vendor = dirname(__DIR__) . DS . 'vendor';
$loader = include $vendor . DS . 'autoload.php';

$loader->add('Nomnom', __DIR__);
