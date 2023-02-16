<?php

namespace app\services;

use app\core\Request;

/**
 * 
 * 
 * @package app\services
 */


interface ICategory
{
    public function createCategory(array $attr);
    public function getCategories();
    public function getAll();
    public function findOne(array $attr);
    public function updateCategory(array $attr);
    public function deleteCategory(array $attr);
    public function getCategoriesWithSearch($attr);
    public function getAllWithSearch(string $text);
}
