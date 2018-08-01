<?php

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
	 *
	 * @param string $login
	 * @param string $password
	 * @param string $email
	 * @return $affectedLines
	 */
	public function addNewUser($login, $password, $email)
	{

		$db = $this->dbConnect();
		$req = $db->prepare('INSERT INTO `users`(`login`, `password`, `email`, `date_sign`) VALUES (?,?,?,NOW())');
		$affectedLines = $req->execute(array($login, $password, $email));

		return $affectedLines;
	}

	/**
	 * Fonction qui vérifie si l'info entré en paramètre est un entier ou une chaîne de caractère
	 * Pour vérifier si l'utilisateur existe de par tson Id ou son login
	 *
	 * @param mix $info
	 * @return bool
	 */
	public function exists($info)
	{

		if (ctype_digit($info)) {

			$db = $this->dbConnect();
			$q = $db->prepare('SELECT COUNT(*) FROM users WHERE ID = :id');
			$q->execute([':id' => $info]);

			return (bool)$q->fetchColumn();

		} else {

			$db = $this->dbConnect();
			$q = $db->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
			$q->execute([':login' => $info]);

			return (bool)$q->fetchColumn();
		}
	}

	/**
	 * Fonction qui vérifie si le mail existe déjà dans la base de donnée
	 *
	 * @param string $info
	 * @return bool
	 */
	public function existMail($info)
	{

		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
		$q->execute([':email' => $info]);

		return (bool)$q->fetchColumn();
	}

	/**
	 * Fonction qui récupère toutes les infos d'un utilisateur à partir de son login
	 *
	 * @param string $log
	 * @return $userInfos
	 */
	public function userInfos($log)
	{

		$db = $this->dbConnect();
		$q = $db->prepare('SELECT *, DATE_FORMAT(date_sign, \'%d/%m/%Y \') AS date_sign FROM users WHERE login = :log');
		$q->execute([':log' => $log]);
		$userInfos = $q->fetch();

		return $userInfos;
	}

	/**
	 * Fonction qui met à jour les information de l'utilisateur
	 *
	 * @param int $userId
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

		return $updatedUser;
	}

	/**
	 * Fonction qui supprime l'utilisateur
	 *
	 * @param int $userId
	 * @return void
	 */
	public function deleteUser($userId)
	{

		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM users WHERE id= ?');
		$affectedUser = $req->execute(array($userId));

	}

	/**
	 * Fonction qui récupère tout les utilisateurs ainsi que le nombre total de leurs commentaires
	 *
	 * @return $listUsers
	 */
	public function usersList()
	{

		$db = $this->dbConnect();
		$listUsers = $req = $db->query(
			'SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.country country, u.avatar_path avatar_path, COUNT(c.autor_id) commentsUser
			FROM users u
				LEFT JOIN comments c
				ON c.autor_id = u.ID
			GROUP BY u.ID
			ORDER BY admin DESC, date_sign DESC'
		);
		return $listUsers;
	}

	/**
	 * Fonction qui récupère les utilisateurs et leurs commentaires mais qui les tri par le bannissement
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
			GROUP BY u.ID
			ORDER BY ban, date_sign DESC'
		);
		return $listUsers;
	}

	/**
	 * Fonction qui rédéfinie le chemin de l'avatar pour le réinitialiser
	 *
	 * @param int $userId
	 * @return $updatedUser
	 */
	public function initAvatarPath($userId)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare('UPDATE users SET avatar_path = :avatar_path  WHERE ID = :id');
		$updatedUser->execute([
			'avatar_path' => 'public/images/user_avatar/0.jpeg',
			'id' => $userId
		]);

		return $updatedUser;
	}

	/**
	 * Fonction qui modifie le rang de l'utilisateur
	 *
	 * @param int $admin
	 * @param int $userId
	 * @return void
	 */
	public function upgradeUser($admin, $userId)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare('UPDATE users SET admin = :admin  WHERE ID = :id');
		$updatedUser->execute([
			'admin' => $admin,
			'id' => $userId
		]);
	}

	/**
	 * Fonction qui modifie le bannissement d'un utilisateur
	 *
	 * @param int $userId
	 * @param int $ban
	 * @return void
	 */
	public function banUser($userId, $ban)
	{

		$db = $this->dbConnect();
		$updatedUser = $db->prepare('UPDATE users SET ban = :ban  WHERE ID = :id');
		$updatedUser->execute([
			'ban' => $ban,
			'id' => $userId
		]);
	}
}