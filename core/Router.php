<?php

namespace app\core;

class Router
{
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }
    public array $routes = [];

//    ['userCreate','UserController'];
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();

        echo '<pre>';
        var_dump($path);
        var_dump($method);
        exit;
    }
}