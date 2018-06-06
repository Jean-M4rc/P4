<?php

namespace P4\model;

class User {
	
	private 	$id,
				$login,
				$password,
				$email,
				$admin, // les droits :0 abonnés, :1 modérateurs, :2 auteur
				$country, // A définir dans la page personnalisation
				$avatar_path; // A définir dans la page personnalisation
	
	// Les constantes de rôles
	
	const AUTOR_RULE = 2;
	const MODERATOR_RULE = 1;
	const READER_RULE = 0;
	
	// Les GETTERS (permettent d'afficher les attributs privés)
	
	public function id()
	{
			return $this->_id;
	}
	
	public function login()
	{
		return $this->_login;
	}
	
	public function password()
	{
		return $this->_password;
	}
	
	public function email()
	{
		return $this->_email;
	}
	
	public function admin()
	{
		return $this->_admin;
	}
	
	public function country()
	{
		return $this->_counry;
	}
	
	public function avatar_path()
	{
		return $this->_avatar_path;
	}
	
	// Les SETTERS (contrôle l'intégrité des attributs envoyés)
	
	public function setId($id)
	{
		$id = (int) $id;
		
		if ($id >0)
		{
			$this->_id = $id;
		}
	}
	
	public function setLogin($login)
	{
		if(is_string($login))
		{
				$this->_login = $login;
		}
	}
	
	public function setPassword($password)
	{
		if(is_string($password))
		{
				$this->_password = $password;
		}
	}
	
	public function setEmail($email)
	{
		if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)){
			$this->_email = $email;
		}
	}
	
	public function setAdmin($admin)
	{
		$admin = (int) $admin;
		if($admin >= 0){
			$this->_admin = $admin;
		}
	}
	
	public function setCoutrny($country)
	{
		if(is_string($country))
		{
				$this->_country = $country;
		}
	}
	
	public function setAvatar_path($avatar_path)
	{
		if(is_string($avatar_path))
		{
				$this->_avatar_path = $avatar_path;
		}
	}
	
	// Les fonctions
		
	public function __construct($userData = []){
		if(!empty($userData)){
			$this->hydrate($userData);
		}
	}
	
	public function hydrate(array $userData){
		foreach ($userData as $key => $value){
			// On récupère le nom du setter correspondant à l'attribut.
			$method = 'set'.ucfirst($key);  
			// Si le setter correspondant existe.
			if (method_exists($this, $method)){
				// On appelle le setter.
				$this->$method($value);
			}
		}
	}
	
	// Gestion des rôles ------------------
	
	public function makeModerator(User $user)
	{
		$user->setAdmin(1);
	}
	
	public function makeAutor(User $user)
	{
		$user->setAdmin(2);
	}
	
	public function eraseRight(User $user)
	{
		$user->setAdmin(0);
	}
}