<?php

namespace ToFarias\Framework;

class Router
{
    private $routes = [];

    public function __construct()
    {
    }

    public function add(string $method, string $pattern, $callback)
    {
        $method = strtolower( trim($method) );
        $pattern = '/^'.str_replace('/', '\/',$pattern).'$/';
        $this->routes[$method][$pattern] = $callback;
    }

    public function run()
    {
        $url =$this->getUrl();
        $method = strtolower( $_SERVER['REQUEST_METHOD'] );

        if(empty($this->routes[$method])){
            return 'Page Not Found';
        }

        foreach ($this->routes[$method] as $route => $action)
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