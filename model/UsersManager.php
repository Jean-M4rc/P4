<?php

namespace P4\model;

/**
 * Classe qui permet le CRUD des abonnés.
 */
class UsersManager extends Manager{
	

	/**
	 * Ajoute un abonné dans la base de données.
	 *
	 * @param string $login
	 * @param string $password
	 * @param string $email
	 * @return void
	 */
	public function addNewUser($login, $password, $email){
				
		$db = $this->dbConnect();
		$req = $db->prepare(
			'INSERT INTO users(login, password, email, date_sign)
			VALUES (?,?,?,NOW())'
		);
		$affectedLines=$req->execute(array($login, $password, $email));
		return $affectedLines;
	}	
	
	/**
	 * Vérifie l'existence ou non d'un abonné par son id ou son login.
	 *
	 * @param mixed $info
	 * @return bool
	 */
	public function exists($info){
		
		if (ctype_digit($info)) {
			$db = $this->dbConnect();
			$q = $db->prepare(
				'SELECT COUNT(*) 
				FROM users 
				WHERE ID = :id'
			);
			$q->execute([':id'=>$info]);
			return (bool) $q->fetchColumn();

		} else {
			
			$db = $this->dbConnect();
			$q = $db->prepare(
				'SELECT COUNT(*) 
				FROM users 
				WHERE login = :login'
			);
			$q->execute([':login'=>$info]);
			return (bool) $q->fetchColumn();
		}
	}
	
	/**
	 * Vérifie l'existence de l'adresse mail dans la bdd.
	 *
	 * @param string $info
	 * @return bool
	 */
	public function existMail($info){

		$db = $this->dbConnect();
		$q = $db->prepare(
			'SELECT COUNT(*) 
			FROM users 
			WHERE email = :email'
		);
		$q->execute([':email'=>$info]);
		return (bool) $q->fetchColumn();
	}
	
	/**
	 * Récupère les données d'un abonné.
	 *
	 * @param string $log
	 * @return $userInfos
	 */
	public function userInfos($log){

		$db = $this->dbConnect();
		$q = $db->prepare(
			'SELECT *, DATE_FORMAT(date_sign, \'%d/%m/%Y \') AS date_sign 
			FROM users 
			WHERE login = :log'
		);
		$q->execute([':log'=>$log]);
		$userInfos = $q->fetch();
		return $userInfos;
	}
	
	/**
	 * Met à jour les informations de l'abonné.
	 *
	 * @param string $userId
	 * @param string $pseudo
	 * @param string $email
	 * @param string $password
	 * @param string $country
	 * @param string $avatar_path
	 * @return $updatedUser
	 */
	public function updateUserInfo($userId, $pseudo, $email, $password, $country, $avatar_path){

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
	 * Supprime un abonné de la bdd.
	 *
	 * @param int $userId
	 * @return void
	 */
	public function deleteUser($userId){

		$db = $this->dbConnect();
		$req = $db->prepare(
			'DELETE FROM users 
			WHERE id= ?'
		);
		$affectedUser=$req->execute(array($userId));
	}
	
	/**
	 * Permet de récupérer la liste des abonnés ainsi que le nombre de commentaires de chaque abonné.
	 *
	 * @return $listUsers
	 */
	public function usersList(){

		$db = $this->dbConnect();
		$listUsers = $req = $db->query(
			'SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.country country, u.avatar_path avatar_path,
			COUNT(c.autor_id) commentsUser
			FROM users u
				LEFT JOIN comments c
				ON c.autor_id = u.ID
				GROUP BY u.ID
			ORDER BY admin DESC, date_sign DESC'
		);		
		return $listUsers;
	}
	
	/**
	 * Récupère les informations sur les abonnés pour les gérer.
	 *
	 * @return $listUsers
	 */
	public function listUsersEdit(){

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
	 * Réinitilise la valeur du chemin de l'avatar dans la bdd.
	 *
	 * @param int $userId
	 * @return $updatedUser
	 */
	public function initAvatarPath($userId){

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
		return $updatedUser;
	}
	
	/**
	 * Défini la valuer de l'entrée $admin pour gérer le rôle de l'abonné.
	 *
	 * @param int $admin
	 * @param int $userId
	 * @return void
	 */
	public function upgradeUser($admin,$userId){

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
	 * Modifie la valuer de l'attribut ban pour régler le bannissement de l'abonné.
	 *
	 * @param int $userId
	 * @param int $ban
	 * @return void
	 */
	public function banUser($userId, $ban){

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

?>