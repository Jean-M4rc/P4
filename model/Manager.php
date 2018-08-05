<?php

namespace P4\model;

/**
 * Classe mère des autres manangers.
 * Elle permet la connexion à la base de données en prenant les valeurs définies dans le fichier const.php
 */
class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=' . $GLOBALS['host'] . ';dbname=' . $GLOBALS['dbname'] . ';charset=' . $GLOBALS['charset'], $GLOBALS['user'], $GLOBALS['password']);
        return $db;
    }
}