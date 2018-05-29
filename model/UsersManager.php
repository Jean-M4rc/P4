<?php

// Le model UserManager est une class qui comprendra les différents manipulations des users:

// de la connexion,

// à l'inscription/création d'un utilisateur lambda

// à la validation

// de la déconnexion

// de la personnalisation du profil 

// de la gestion des users par l'admin role(modrateur, auteur, abonné)

// de la suppression
namespace P4\model;

require_once ('model/Manager.php');
require_once('model/USer.php');

class UsersManager extends Manager 
{
	
	
	public function addNewUser(User $user)
	{
		// Ici on fait la création d'un abonné. On créer l'entrée dans la base de données.
		
		// Vérouillage des failles XSS
		$login = htmlspecialchars($_POST['login']);
		$mdp1 = htmlspecialchars($_POST['mdp1']);
		$mdp2 = htmlspecialchars($_POST['mdp2']);
		$email = htmlspecialchars($_POST['mail_user']);
		
		echo "On est dans le UsersMananger, donc dans le model <br/><br/>";
		echo "Le pseudo est : " . $login . "<br/>";
		echo "Le mdp1 est : " . $mdp1 . "<br/>";
		echo "Le mdp2 est : " . $mdp2 . "<br/>";
		echo "Le mail est : " . $email . "<br/><br/>";
		
		// Ici on va tester les donnees reçues
		$db = $this->dbConnect();
		//Test du pseudo libre
		//Recherche dans la table s'il existe le même pseudo (filtre WHERE) s'il y a une réponse cela renvoi true sinon false
		$req = $db->prepare('SELECT ID FROM users WHERE login = ?');
		$req -> execute(array($login));
		
		if ($testpseudo = $req->fetch()){
			// Si cette condition est vraie le pseudo est déjà utilisé
			// Alors on redirige vers index.php avec une vue qui active la modal d'inscriptiuon avec le message d'erreur
			echo 'le login est déjà utilisé';
			
			$_SESSION['errorField'] = 'login';
			header('location:index.php?erreurSignForm=true');
			
		} elseif ($mdp1 != $mdp2){ //Test du mot de passe identiques
		
			echo 'Les mots de passe ne sont pas identiques';

			header('location:index.php?erreurSignForm=true');
	
		} else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)){// Test de la Regex sur l'email
		
			echo 'L\'adresse mail n\'est pas de format correcte';
			header('location:index.php?erreurSignForm=true');
	
		} else { //Tout les test sont bons, ont hache le mdp et on insert
			$password = password_hash($mdp2, PASSWORD_DEFAULT);
			echo $password . '<br/>';
			
			echo 'la session a démarré ?<br/>';
			$_SESSION['errorField'] = "RAS";
			echo $_SESSION['errorField'];
			// Ici l'écrituere en BDD
			
		};
		
		// Préparation de la requête d'insertion.
		
		// Assignation des valeurs pour le nom de l'abonné.
		
		// Exécution de la requête.
		
		// Hydratation de l'abonné passé en paramètre avec assignation de son identifiant et des personnalisations initiales (= 0).
		
		
		$q = $db->prepare('INSERT INTO users(login, password, email) VALUES(:login, :password, :email)');
		$q->bindValue(':login', $login);
		$q->bindValue(':password', $password);
		$q->bindValue(':email', $email);
		
		$q->execute();
		
		$user->hydrate([
			'admin' => 0,
			'name' => 'à définir',
			'nick_name' => 'à définir',
			'country' => 'à définir',
			'avatar_path' => 'à définir'
			]);
		$_SESSION['modalView'] = 'signed';
		
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
		
		$q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE login = :login');
		$q->execute([':nom'=>$info]);
		
		return (bool) $q->fetchColumn();
	}


}

?>