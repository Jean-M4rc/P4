<?php

namespace Jim\P4\model; //la classe sera dans ce namespace

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=P4;charset=utf8', 'root', '');
        return $db;
    }
}
?>