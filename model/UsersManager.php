<?php
// ---------------------------------------------------------------------- //
// --------- P4 --------------- MODEL\UserManager ----------------------- //
// ---------------------------------------------------------------------- //

// de la connexion/déconnexion
// à l'inscription/création d'un utilisateur lambda
// à la validation
// de la personnalisation du profil 
// de la gestion des users par l'admin role (moderateur, auteur, abonné)
// de la suppression

namespace P4\model;

require_once ('model/Manager.php');
//require_once('model/User.php');

class UsersManager extends Manager 
{
	public function addNewUser($login, $password, $email)
	{
		// Ici on fait la création d'un abonné. On créer l'entrée dans la base de données.
		// Ici l'écriture en BDD
		
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
			
		if (ctype_digit($info)) // On veut savoir si tel personnage ayant pour id $info existe.
		{
			$db = $this->dbConnect();
			$q = $db->prepare('SELECT COUNT(*) FROM users WHERE ID = :id');
			$q->execute([':id'=>$info]);
			
			return (bool) $q->fetchColumn();
		}
		else
		{
		
		// Sinon, c'est que l'on veut vérifier si le nom existe ou pas.
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
		$q->execute([':login'=>$info]);
		
		return (bool) $q->fetchColumn();
		}
	}
		
	public function existMail($info)
	{
		// Sinon, c'est que l'on veut vérifier si le nom existe ou pas.
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
		$q->execute([':email'=>$info]);
		
		return (bool) $q->fetchColumn();
	}
	
	public function userInfos($log) // fonction a mettre dans l'objet User
	{
		$db = $this->dbConnect();
		$q = $db->prepare('SELECT *, DATE_FORMAT(date_sign, \'%d/%m/%Y \') AS date_sign FROM users WHERE login = :log');
		$q->execute([':log'=>$log]);
		$userInfos = $q->fetch();
		
		return $userInfos;
	}
	
	public function updateUserInfo($userId, $pseudo, $email, $password, $country, $avatar_path)
	{
		$db = $this->dbConnect();
		$updatedUser = $db->prepare('UPDATE users SET login = :pseudo, email = :email, password = :password, country = :country, avatar_path = :avatar_path  WHERE ID = :id');
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

	public function deleteUser($userId)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM users WHERE id= ?');

		$affectedUser=$req->execute(array($userId));
		
	}
	
	public function listUsers()
	{
		$db = $this->dbConnect();
		$listUsers = $req = $db->query('
		SELECT u.ID userID, u.login login, u.email email, DATE_FORMAT(u.date_sign, \'%d/%m/%Y \') AS date_sign_fr, u.admin admin, u.avatar_path avatar_path, u.ban ban,
		COUNT(c.autor_id) commentsUser
		FROM users u
		LEFT JOIN comments c
		ON c.autor_id = u.ID
		GROUP BY u.ID
		ORDER BY ban, date_sign DESC');		
		return $listUsers;
	}
	
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

	public function upgradeUser($admin,$userId)
	{
		$db = $this->dbConnect();
		$updatedUser = $db->prepare('UPDATE users SET admin = :admin  WHERE ID = :id');
		$updatedUser->execute([
		'admin' => $admin,
		'id' => $userId
		]);
	}
	
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

?>