<?php

namespace app\core;

/**
 * Class Application
 * 
 * @package app\core
 */

class BaseController
{

    public function render($view, $parameters = [])
    {
        return Application::$coreApp->router->renderView($view, $parameters);
    }
}
