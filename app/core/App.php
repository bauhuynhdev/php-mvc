<?php


class App
{
    protected $controller = 'Pages';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $route = $this->getRoute();

        if (isset($route[0]) && file_exists('../app/controllers/' . ucwords($route[0]) . '.php')) {
            $this->controller = ucwords($route[0]);
            unset($route[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($route[1]) && method_exists($this->controller, $route[1])) {
            $this->method = $route[1];
            unset($route[1]);
        }

        if ($route) {
            $this->params = array_values($route);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getRoute()
    {
        if (isset($_GET['route'])) {
            $route = rtrim($_GET['route'], '/');
            $route = filter_var($route, FILTER_SANITIZE_URL);
            $route = explode('/', $route);

            return $route;
        }
    }
}