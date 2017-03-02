<?php
require('config.php');
require('core/autoload/autoload.php');

$autoloader = new Autoload();

spl_autoload_register([$autoloader, 'load']);

$autoloader->register('viewloader', function(){
    return require(BASEPATH.'/core/view/viewLoader.php');
});

$view = new View( new ViewLoader(BASEPATH.'/views/') );
$router = new Router();