<?php

namespace app\core;

/**
 * 
 * 
 * @package app\core
 */


abstract class AbstractDatabase extends Database
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;

    public function insert($attr)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $values = array_map(fn ($key) => "'$key'", $attr);
        $sql = self::prepare("INSERT INTO $tableName(" . implode(',', $attributes) . ") VALUES (" . implode(',', $values) . ")");
        $sql->execute();
        return true;
    }

    public function update($where)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode(" WHERE ", array_map(function ($value, $key) {
            return "`$key` = '$value'";
        }, $where, $attributes));
        $stament = self::prepare("UPDATE `$tableName` SET $sql");
        $stament->execute();
        return true;
    }

    public function delete(array $attr)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($attr);
        $sql = implode(" WHERE ", array_map(function ($value, $key) {
            return "`$key` = '$value'";
        }, $attr, $attributes));
        $stament = self::prepare("DELETE FROM `$tableName` WHERE $sql");
        $stament->execute();
        return true;
    }

    public function getCategories($parent_id = null)
    {
        $categories = array();
        $tableName = $this->tableName();
        $sql = self::prepare("SELECT * FROM $tableName WHERE parentID = " . ($parent_id ? $parent_id : "0"));
        $sql->execute();
        while ($row = $sql->fetchObject()) {
            $category = array(
                'id' => $row->id,
                'name' => $row->name,
                'children' => array()
            );
            $children = $this->getCategories($row->id);
            if ($children) {
                $category['children'] = $children;
            }
            $categories[] = $category;
        }
        return $categories;
    }

    public function findOne($where)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(function ($value, $key) {
            return "`$key` = '$value'";
        }, $where, $attributes));

        $stament = self::prepare("SELECT * FROM $tableName WHERE $sql");
        $stament->execute();
        return $stament->fetchObject();
    }

    public function getAll()
    {
        $categories = array();
        $tableName = $this->tableName();
        $sql = self::prepare("SELECT * FROM $tableName");
        $sql->execute();
        while ($row = $sql->fetchObject()) {
            $category = array(
                'id' => $row->id,
                'name' => $row->name,
            );
            $categories[] = $category;
        }
        return $categories;
    }

    public static function prepare($query)
    {
        return Application::$coreApp->database->pdo->prepare($query);
    }

    public function getCategoriesWithSearch($condition, $parent_id = null)
    {
        $categories = array();
        $tableName = $this->tableName();
        $sql = self::prepare("SELECT * FROM $tableName WHERE `name` LIKE '%$condition%' AND parentID = " . ($parent_id ? $parent_id : "0"));
        $sql->execute();
        while ($row = $sql->fetchObject()) {
            $category = array(
                'id' => $row->id,
                'name' => $row->name,
                'children' => array()
            );
            $children = $this->getCategories($row->id);
            if ($children) {
                $category['children'] = $children;
            }
            $categories[] = $category;
        }
        return $categories;
    }

    public function getAllWithSearch(string $text)
    {
        $categories = array();
        $tableName = $this->tableName();
        $sql = self::prepare("SELECT * FROM $tableName WHERE `name` LIKE '%$text%'");
        $sql->execute();
        while ($row = $sql->fetchObject()) {
            $category = array(
                'id' => $row->id,
                'name' => $row->name,
            );
            $categories[] = $category;
        }
        return $categories;
    }
}
