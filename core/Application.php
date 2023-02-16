<?php

namespace app\core;

use app\controllers\CategoryController;
use app\core\Application as CoreApplication;
use app\repository\CategoryRepository;
use app\services\impl\CategoryImpl;

/**
 * Class Application
 * 
 * @package app\core
 */

class Application
{
    public static string $ROOT_DIR;
    public static CoreApplication $coreApp;

    public Router $router;
    public Request $request;
    public Response $response;
    public Database $database;
    public CategoryImpl $categoryService;
    public CategoryRepository $categoryRepository;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$coreApp = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->database = new Database();

        $this->categoryRepository = new CategoryRepository();
        $this->categoryService = new CategoryImpl($this->categoryRepository);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
