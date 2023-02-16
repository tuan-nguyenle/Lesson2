<?php

namespace app\core;

use app\core\Request;
use app\core\Response;

/**
 * Class Application
 * 
 * @package app\core
 */

class Router
{
    public Request $request;
    public Response $response;

    private array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    // if haven't URI return 404 page
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            // echo "404 Error - Page Not Found!";
            Application::$coreApp->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        // creates a new instance of a class based on the first element of an array.\
        // callback[0] is ClassController so we new instance of a class based on the first element of an array

        $callback[0] = new $callback[0]();
        // call_user_func — Call the callback given by the first parameter
        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view)
    {
        $layout = $this->getLayout();
        $view = $this->getView($view);
        // print_r($view);
        $render = str_replace('{{content}}', $view, $layout);
        return $render;
    }

    public function getLayout()
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/layout.php";
        return ob_get_clean();
    }

    public function getView($view)
    {
        // foreach ($parameters as $key => $value) {
        //     $$key = $value;
        // }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
