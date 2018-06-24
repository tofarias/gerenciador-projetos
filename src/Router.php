<?php

namespace ToFarias\Framework;

class Router
{
    private $routes = [];

    public function __construct()
    {
    }

    public function add(string $pattern, $callback)
    {
        $pattern = '/^'.str_replace('/', '\/',$pattern).'$/';
        $this->routes[$pattern] = $callback;
    }

    public function run()
    {
        //$url = $_SERVER['PATH_INFO'] ?? '/';
        $url =$this->getUrl();

        foreach ($this->routes as $route => $action)
        {
            if( preg_match($route, $url, $params) ){
                return $action($params);
            }
        }

        if( array_key_exists($route, $this->routes) ){
            return $this->routes[$route]();
        }
        return 'Page Not Found';
    }

    public function getUrl()
    {
        $url = $_SERVER['PATH_INFO'] ?? '/';

        if(strlen($url) > 1){
            $url = rtrim($url, '/');
        }

        return $url;
    }
}