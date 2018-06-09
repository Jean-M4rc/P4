<?php

namespace P4\model; //la classe sera dans ce namespace

class Manager
{
    protected function dbConnect()
	{
		/* methode sqli
		$host_name = 'db741329164.db.1and1.com';
		$database = 'db741329164';
		$user_name = 'dbo741329164';
		$password = '55ee4a7@X';
		$connect = mysqli_connect($host_name, $user_name, $password, $database);

		if (mysqli_connect_errno()) {
			die('<p>La connexion au serveur MySQL a échoué: '.mysqli_connect_error().'</p>');
		} else {
			echo '<p>Connexion au serveur MySQL établie avec succès.</p >';
		}
		
		$host_name = 'db741329164.db.1and1.com';
		$database = 'db741329164';
		$user_name = 'dbo741329164';
		$password = '55ee4a7@X';

		$connect = mysql_connect($host_name, $user_name, $password, $database);
		if (mysql_errno()) {
			die('<p>La connexion au serveur MySQL a échoué: '.mysql_error().'</p>');
		} else {
			echo '<p>Connexion au serveur MySQL établie avec succès.</p >';
		}
		*/
		
        $db = new \PDO('mysql:host=localhost;dbname=p4;charset=utf8','root', '');

        return $db;
		
		/*
		$host_name = 'db741329164.db.1and1.com';
		$database = 'db741329164';
		$user_name = 'dbo741329164';
		$password = '55ee4a7@X';

		$db = null;
		try {
		  $db = new \PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
		  
		} catch (PDOException $e) {
		  echo "Erreur!: " . $e->getMessage() . "<br/>";
		  die();
		}
		
		return $db;
		*/
	}
}
?>