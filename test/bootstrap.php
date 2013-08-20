<?php
if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

$vendor = dirname(__DIR__) . DS . 'vendor';
$loader = include $vendor . DS . 'autoload.php';

$loader->add('Nomnom', __DIR__);