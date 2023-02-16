<?php

namespace app\models;

use app\core\AbstractDatabase;


/**
 * Class CategoryController
 * 
 * @package app\models
 */

class Category extends AbstractDatabase
{
    // mã, tên, danh mục cha
    protected int $id;
    protected string $name;
    protected int $parentID;

    public function tableName(): string
    {
        return 'category';
    }

    public function attributes(): array
    {
        return ['name', 'parentID'];
    }
}
