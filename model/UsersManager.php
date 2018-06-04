<?php
// ---------------------------------------------------------------------- //
// --------- P4 --------------- MODEL\UserManager ----------------------- //
// ---------------------------------------------------------------------- //

// de la connexion/déconnexion
// à l'inscription/création d'un utilisateur lambda
// à la validation
// de la personnalisation du profil 
// de la gestion des users par l'admin role(modrateur, auteur, abonné)
// de la suppression

namespace P4\model;

require_once ('model/Manager.php');
require_once('model/USer.php');

class UsersManager extends Manager 
{
	public function addNewUser($login, $password, $email)
	{
		// Ici on fait la création d'un abonné. On créer l'entrée dans la base de données.
		// Les donnees sont déjà testés, on effectue ici seulement l'écriture dans la bdd
		// Ici l'écrituere en BDD
		echo 'ici commence la requete sql<br/>';
		
		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO `users`(`login`, `password`, `email`, `date_sign`) VALUES (?,?,?,NOW())');

		$affectedLines=$req->execute(array($login, $password, $email));
		
		return $affectedLines;
	}	
	
	public function exists($info)
	{
		// Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
			// Donc on exécute une requête COUNT() avec une clause WHERE, et on retourne un boolean.
		// Sinon c'est que l'on a passé un nom.
			// Donc on exécute une requête COUNT() avec une clause WHERE, et on retourne un boolean.
			
		if (is_int($info)) // On veut savoir si tel personnage ayant pour id $info existe.
		{
			return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();
		}
		
		// Sinon, c'est que l'on veut vérifier si le nom existe ou pas.
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
		$q->execute([':login'=>$info]);
		
		return (bool) $q->fetchColumn();
	}
	
	public function existMail($info)
	{
		// Sinon, c'est que l'on veut vérifier si le nom existe ou pas.
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
		$q->execute([':email'=>$info]);
		
		return (bool) $q->fetchColumn();
	}
	
	public function userInfos($log)
	{
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT * FROM users WHERE login = :log');
		$q->execute([':log'=>$log]);
		$userInfos = $q->fetch();
		
		return $userInfos;
	}


}

?>