<?php

require __DIR__."/vendor/autoload.php";

$router = new \ToFarias\Framework\Router();

$router->add('GET','/', function(){
    return 'Home';
});

$router->add('GET','/projects/(\d+)', function($params){
    return 'Projects '.$params[1];
});

echo $router->run();