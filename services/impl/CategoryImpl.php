<?php

namespace app\services\impl;

use app\repository\CategoryRepository;
use app\services\ICategory;

/**
 * 
 * @package app\services\impl
 */

class CategoryImpl implements ICategory
{
    protected $repoCategory;
    public function __construct(CategoryRepository $repoCategory)
    {
        $this->repoCategory = $repoCategory;
    }

    public function createCategory(array $attr)
    {
        $this->repoCategory->insert($attr);
    }

    public function getCategories()
    {
        return $this->repoCategory->getCategories();
    }

    public function getAll()
    {
        return $this->repoCategory->getAll();
    }

    public function findOne(array $attr)
    {
        return $this->repoCategory->findOne($attr);
    }

    public function updateCategory(array $attr)
    {
        return $this->repoCategory->updateCategory($attr);
    }

    public function deleteCategory(array $attr)
    {
        return $this->repoCategory->deleteCategory($attr);
    }

    public function getCategoriesWithSearch($attr)
    {
        return $this->repoCategory->getCategoriesWithSearch($attr);
    }

    public function getAllWithSearch(string $text)
    {
        return $this->repoCategory->getAllWithSearch($text);
    }
}
