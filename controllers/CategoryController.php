<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\repository\CategoryRepository;
use app\services\impl\CategoryImpl;

/**
 * Class CategoryController
 * 
 * @package app\controllers
 */

class CategoryController extends BaseController
{
    protected $categoryService;
    public function __construct()
    {
        $categoryRepository = new CategoryRepository();
        $this->categoryService = new CategoryImpl($categoryRepository);
    }

    public function home()
    {
        return $this->render("category");
    }

    public function handlePostDataCategory(Request $request)
    {
        $data = $request->getParameters();
        $this->categoryService->createCategory($data);
        header("Location: http://localhost:8080");
        exit;
    }

    public function category()
    {
        $this->categoryService->getCategories();
    }

    public function getDetailCategory(Request $request)
    {
        $data = $this->categoryService->findOne($request->getParameters());
        die(json_encode($data));
    }

    public function updateCategory(Request $request)
    {
        $statusCode = $this->categoryService->updateCategory($request->getParameters());
        die(json_encode($statusCode));
    }

    public function deleteCategory(Request $request)
    {
        $statusCode = $this->categoryService->deleteCategory($request->getParameters());
        die(json_encode($statusCode));
    }

    public function getCategoriesWithSearch(Request $request)
    {
        $this->categoryService->getCategoriesWithSearch($request->getParameters());
    }

    public function getAllWithSearch(Request $request)
    {
        $this->categoryService->getAllWithSearch($request->getParameters());
    }
}
