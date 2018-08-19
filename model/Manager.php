<?php
<<<<<<< HEAD
/**
 * class Manager qui permet la connexion à la base de données
 * 
 * @author Jean-MArc Voisin <jeanmarc.voisin.tai@gmail.com>
 */
namespace P4\model; //la classe sera dans ce namespace
=======

namespace P4\model;
>>>>>>> poo_transform

/**
 * Classe mère des autres Managers.
 * Elle permet la connexion à la base de données
 * en prenant les valeurs définies dans le fichier const.php
 */
class Manager
{
    /**
     * Fonction dbConnect qui permettra aux autres manageurs de se connecter à la BDD
     *
     * @return $db
     */
    protected function dbConnect()
<<<<<<< HEAD
	{
        $db = new \PDO('mysql:host=db746234658.db.1and1.com;dbname=db746234658;charset=utf8','dbo746234658', 'Juann@X0');
        return $db;
	}
}
?>
=======
    {
        $db = new \PDO('mysql:
        host=' . $GLOBALS['host'] . ';
        dbname=' . $GLOBALS['dbname'] . ';
        charset=' . $GLOBALS['charset'],
        $GLOBALS['user'],
        $GLOBALS['password']
        );
        return $db;
    }
}
>>>>>>> poo_transform
