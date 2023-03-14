<?php

namespace Mosyle;

use App\Controllers\ApiController;

class Route
{

    private $uri;
    private $controller;
    private $method;
    private $action;

    public function __construct($uri, $controller, $method, $action)
    {
        $this->uri = $uri;
        $this->controller = new $controller();
        $this->method = $method;
        $this->action = $action;
    }

    public function call($args)
    {
        if (method_exists($this->controller, $this->action)) {
            return $this->controller->{$this->action}(...$args);
        } else {
            throw new \Exception("Method not found");
        }
    }

    public function uri()
    {
        return $this->uri;
    }

    public function method()
    {
        return $this->method;
    }

    public function isApi() : bool
    {
        return $this->controller instanceof ApiController;
    }

}