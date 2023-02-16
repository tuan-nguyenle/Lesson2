<?php

namespace app\core;

use PDO;

/**
 * Class Database
 * 
 * @package app\core
 */

class Database
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=lesson2", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
