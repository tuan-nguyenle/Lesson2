<?php
require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\controllers\CategoryController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', [CategoryController::class, "home"]);
$app->router->post('/', [CategoryController::class, "handlePostDataCategory"]);
$app->router->post('/category', [CategoryController::class, "getDetailCategory"]);
$app->router->post('/update', [CategoryController::class, "updateCategory"]);
$app->router->post('/delete', [CategoryController::class, "deleteCategory"]);

$app->run();
