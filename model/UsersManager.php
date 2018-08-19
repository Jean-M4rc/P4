<?php
<<<<<<< HEAD

/**
 * class UsersManager qui permet de gérer les utilisateurs
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com>
 */

namespace P4\model;

require_once('model/Manager.php');

class UsersManager extends Manager
{
	/**
	 * Fonction qui ajoute un nouvel utilisateur dans la bdd
=======

namespace P4\model;

/**
 * Classe qui permet le CRUD des abonnés.
 */
class UsersManager extends Manager
{
	/**
	 * Ajoute un abonné dans la base de données.
>>>>>>> poo_transform
	 *
	 * @param string $login
	 * @param string $password
	 * @param string $email
<<<<<<< HEAD
	 * @return $affectedLines
	 */
	public function addNewUser($login, $password, $email)
	{

		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO `users`(`login`, `password`, `email`, `date_sign`) VALUES (?,?,?,NOW())');
		$affectedLines = $req->execute(array($login, $password, $email));

=======
	 * @return void
	 */
	public function addNewUser($login, $password, $email)
	{

		$db = $this->dbConnect();
		$req = $db->prepare(
			'INSERT INTO users(login, password, email, date_sign)
			VALUES (?,?,?,NOW())'
		);
		$affectedLines = $req->execute(array($login, $password, $email));
>>>>>>> poo_transform
		return $affectedLines;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui vérifie si l'info entré en paramètre est un entier ou une chaîne de caractère
	 * Pour vérifier si l'utilisateur existe de par tson Id ou son login
	 *
	 * @param mix $info
=======
	 * Vérifie l'existence ou non d'un abonné par son id ou son login.
	 *
	 * @param mixed $info
>>>>>>> poo_transform
	 * @return bool
	 */
	public function exists($info)
	{

		if (ctype_digit($info)) {
<<<<<<< HEAD

			$db = $this->dbConnect();
			$q = $db->prepare('SELECT COUNT(*) FROM users WHERE ID = :id');
			$q->execute([':id' => $info]);

=======
			$db = $this->dbConnect();
			$q = $db->prepare(
				'SELECT COUNT(*) 
				FROM users 
				WHERE ID = :id'
			);
			$q->execute([':id' => $info]);
>>>>>>> poo_transform
			return (bool)$q->fetchColumn();

		} else {

			$db = $this->dbConnect();
<<<<<<< HEAD
			$q = $db->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
			$q->execute([':login' => $info]);

=======
			$q = $db->prepare(
				'SELECT COUNT(*) 
				FROM users 
				WHERE login = :login'
			);
			$q->execute([':login' => $info]);
>>>>>>> poo_transform
			return (bool)$q->fetchColumn();
		}
	}

	/**
<<<<<<< HEAD
	 * Fonction qui vérifie si le mail existe déjà dans la base de donnée
=======
	 * Vérifie l'existence de l'adresse mail dans la bdd.
>>>>>>> poo_transform
	 *
	 * @param string $info
	 * @return bool
	 */
	public function existMail($info)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
		$q->execute([':email' => $info]);

=======
		$q = $db->prepare(
			'SELECT COUNT(*) 
			FROM users 
			WHERE email = :email'
		);
		$q->execute([':email' => $info]);
>>>>>>> poo_transform
		return (bool)$q->fetchColumn();
	}

	/**
<<<<<<< HEAD
	 * Fonction qui récupère toutes les infos d'un utilisateur à partir de son login
=======
	 * Récupère les données d'un abonné.
>>>>>>> poo_transform
	 *
	 * @param string $log
	 * @return $userInfos
	 */
	public function userInfos($log)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$q = $db->prepare('SELECT *, DATE_FORMAT(date_sign, \'%d/%m/%Y \') AS date_sign FROM users WHERE login = :log');
		$q->execute([':log' => $log]);
		$userInfos = $q->fetch();

=======
		$q = $db->prepare(
			'SELECT *, DATE_FORMAT(date_sign, \'%d/%m/%Y \') AS date_sign 
			FROM users 
			WHERE login = :log'
		);
		$q->execute([':log' => $log]);
		$userInfos = $q->fetch();
>>>>>>> poo_transform
		return $userInfos;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui met à jour les information de l'utilisateur
	 *
	 * @param int $userId
=======
	 * Met à jour les informations de l'abonné.
	 *
	 * @param string $userId
>>>>>>> poo_transform
	 * @param string $pseudo
	 * @param string $email
	 * @param string $password
	 * @param string $country
	 * @param string $avatar_path
	 * @return $updatedUser
	 */
	public function updateUserInfo($userId, $pseudo, $email, $password, $country, $avatar_path)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare(
			'UPDATE users 
			SET login = :pseudo, email = :email, password = :password, country = :country, avatar_path = :avatar_path  
			WHERE ID = :id'
		);
		$updatedUser->execute([
			'pseudo' => $pseudo,
			'email' => $email,
			'password' => $password,
			'country' => $country,
			'avatar_path' => $avatar_path,
			'id' => $userId
		]);
<<<<<<< HEAD

=======
>>>>>>> poo_transform
		return $updatedUser;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui supprime l'utilisateur
=======
	 * Supprime un abonné de la bdd.
>>>>>>> poo_transform
	 *
	 * @param int $userId
	 * @return void
	 */
	public function deleteUser($userId)
	{
<<<<<<< HEAD

		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM users WHERE id= ?');
		$affectedUser = $req->execute(array($userId));

	}

	/**
	 * Fonction qui récupère tout les utilisateurs ainsi que le nombre total de leurs commentaires
=======

		$db = $this->dbConnect();
		$req = $db->prepare(
			'DELETE FROM users 
			WHERE id= ?'
		);
		$affectedUser = $req->execute(array($userId));
	}

	/**
	 * Permet de récupérer la liste des abonnés ainsi que le nombre de commentaires de chaque abonné.
>>>>>>> poo_transform
	 *
	 * @return $listUsers
	 */
	public function usersList()
	{

		$db = $this->dbConnect();
		$listUsers = $req = $db->query(
<<<<<<< HEAD
			'SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.country country, u.avatar_path avatar_path, COUNT(c.autor_id) commentsUser
			FROM users u
				LEFT JOIN comments c
				ON c.autor_id = u.ID
			GROUP BY u.ID
=======
			'SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.country country, u.avatar_path avatar_path,
			COUNT(c.autor_id) commentsUser
			FROM users u
				LEFT JOIN comments c
				ON c.autor_id = u.ID
				GROUP BY u.ID
>>>>>>> poo_transform
			ORDER BY admin DESC, date_sign DESC'
		);
		return $listUsers;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui récupère les utilisateurs et leurs commentaires mais qui les tri par le bannissement
=======
	 * Récupère les informations sur les abonnés pour les gérer.
>>>>>>> poo_transform
	 *
	 * @return $listUsers
	 */
	public function listUsersEdit()
	{

		$db = $this->dbConnect();
		$listUsers = $req = $db->query(
			'SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.avatar_path avatar_path, u.ban ban,
			COUNT(c.autor_id) commentsUser
			FROM users u
				LEFT JOIN comments c
				ON c.autor_id = u.ID
<<<<<<< HEAD
			GROUP BY u.ID
=======
				GROUP BY u.ID
>>>>>>> poo_transform
			ORDER BY ban, date_sign DESC'
		);
		return $listUsers;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui rédéfinie le chemin de l'avatar pour le réinitialiser
=======
	 * Réinitilise la valeur du chemin de l'avatar dans la bdd.
>>>>>>> poo_transform
	 *
	 * @param int $userId
	 * @return $updatedUser
	 */
	public function initAvatarPath($userId)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare(
			'UPDATE users 
			SET avatar_path = :avatar_path 
			WHERE ID = :id'
		);
		$updatedUser->execute([
			'avatar_path' => 'public/images/user_avatar/0.jpeg',
			'id' => $userId
		]);
<<<<<<< HEAD

=======
>>>>>>> poo_transform
		return $updatedUser;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui modifie le rang de l'utilisateur
=======
	 * Défini la valuer de l'entrée $admin pour gérer le rôle de l'abonné.
>>>>>>> poo_transform
	 *
	 * @param int $admin
	 * @param int $userId
	 * @return void
	 */
	public function upgradeUser($admin, $userId)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare(
			'UPDATE users 
			SET admin = :admin 
			WHERE ID = :id'
		);
		$updatedUser->execute([
			'admin' => $admin,
			'id' => $userId
		]);
	}

	/**
<<<<<<< HEAD
	 * Fonction qui modifie le bannissement d'un utilisateur
=======
	 * Modifie la valuer de l'attribut ban pour régler le bannissement de l'abonné.
>>>>>>> poo_transform
	 *
	 * @param int $userId
	 * @param int $ban
	 * @return void
	 */
	public function banUser($userId, $ban)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare(
			'UPDATE users 
			SET ban = :ban 
			WHERE ID = :id'
		);
		$updatedUser->execute([
			'ban' => $ban,
			'id' => $userId
		]);
	}
}