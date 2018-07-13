<?php

namespace P4\model; //la classe sera dans ce namespace

class Manager
{
    protected function dbConnect()
	{

        $db = new \PDO('mysql:host=localhost;dbname=p4;charset=utf8','root', '');
        return $db;
	}
}