<?php

namespace app\repository;

use app\models\Category;

/**
 * 
 * @package app\repository;
 */


class CategoryRepository
{
    protected $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function insert(array $attr)
    {
        $this->category->insert($attr);
    }

    public function getCategories()
    {
        return $this->category->getCategories();
    }

    public function getAll()
    {
        return $this->category->getAll();
    }

    public function findOne(array $attr)
    {
        return $this->category->findOne($attr);
    }

    public function updateCategory(array $attr)
    {
        return $this->category->update($attr);
    }

    public function deleteCategory(array $attr)
    {
        return $this->category->delete($attr);
    }

    public function getCategoriesWithSearch($attr)
    {
        return $this->category->getCategoriesWithSearch($attr);
    }

    public function getAllWithSearch(string $text)
    {
        return $this->category->getAllWithSearch($text);
    }
}
