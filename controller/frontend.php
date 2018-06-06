<?php

// ---------------------------------------------------------------------- //
// --------- P4 --------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //


// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');



// On n'appelle pas la classe model/Manager car elle est déjà appelé dans les deux classes appelées !

// Le controlleur front-end va proposer les différentes fonctions nécessaires pour les vues publiques.

// je dois créer une classe controler et ensuite faire deux objets, une classe FrontControler et une classe BackendControler

function homePage()
{
	require('view/frontend/homepageView.php');
}

// Première fonction de base listPosts() qui affiche tout les billets de la bdd

function listPosts()
{
	$postsManager = new P4\model\PostsManager(); // Création d'un objet à partir de la classe. Utilisation du namespace
	$posts = $postsManager->getPosts(); // Appel d'une méthode de cette classe pour cet objet.
	require('view/frontend/ListPostsView.php'); // Appel de la vue correspondante.
}

function newUser($login, $mdp1, $mdp2, $email)
{	
	// Vérouillage des failles XSS
	$login = htmlspecialchars($_POST['login']);
	$mdp1 = htmlspecialchars($_POST['mdp1']);
	$mdp2 = htmlspecialchars($_POST['mdp2']);
	$email = htmlspecialchars($_POST['mail_user']);

	// On instance un nouveau manager d'utilisateur pour appliquer ses fonctions
	$userManager = new P4\model\UsersManager();
		
	if ($userManager->exists($login))
	{
		// Si cette condition est vraie le pseudo est déjà utilisé
		header('location:index.php?src=signformError&log=loginused');
		require('view/partial/modalView.php');
	}
	else if (strlen($login)<3)
	{
		header('location:index.php?src=signformError&log=loginshort');
		require('view/partial/modalView.php');
	}
	else if ($mdp1 != $mdp2) //Test du mot de passe identiques
	{
		header('location:index.php?src=signformError&log=passwordmirror');
		require('view/partial/modalView.php');
	}
	else if (strlen($mdp2)<=6) // Test de la longueur du mot de passe
	{
		header('location:index.php?src=signformError&log=passwordshort');
		require('view/partial/modalView.php');
	}
	else if ($userManager->existMail($email)) // Test de l'unicité de l'email
	{
		header('location:index.php?src=signformError&log=mailused');
		require('view/partial/modalView.php');
		
	}
	else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) // Test de la Regex sur l'email
	{
		header('location:index.php?src=signformError&log=mailmirror');
		require('view/partial/modalView.php');
	}
	else //Tout les test sont bons, ont hache le mdp et on insert
	{ 
		$password = password_hash($mdp2, PASSWORD_DEFAULT);
		$affectedUser = $userManager->addNewUser($login, $password, $email);
		$_SESSION['login'] = $login;
		
		header('location:index.php?src=signformSuccess&log=signed');
		require('view/partial/modalView.php');
	}
}

function logUser($login, $password, $cookied)
{
	// Vérouillage des failles XSS
	$login = htmlspecialchars($_POST['pseudo']);
	$password = htmlspecialchars($_POST['mdp']);
	
	$userManager = new P4\model\UsersManager();
	
	// On appelle la méthode pour savoir si ce pseudo existe
	if ($userManager->exists($login)){
		
		// true => on va chercher les infos dans la bdd
		$infoUser = $userManager->userInfos($login);
		
		// Maintenant il faut comparer les mots de passes
		$isPasswordCorrect = password_verify($password, $infoUser['password']);

		if ($isPasswordCorrect)
		{
			// On défini que la session
			$_SESSION['userId'] = $infoUser['ID'];
			$_SESSION['login'] = $infoUser['login'];
			$_SESSION['password'] = $infoUser['password'];
			$_SESSION['date_sign'] = $infoUser['date_sign'];
			$_SESSION['email'] = $infoUser['email'];
			$_SESSION['rule'] =  $infoUser['admin'];
			$_SESSION['country'] = $infoUser['country'];
			$_SESSION['avatar_path'] = $infoUser['avatar_path'];
			
			if ($cookied == 1)
			{
				// On défini les cookies
				setcookie('login', $infoUser['login'], time() + 365*24*3600, null, null, false, true);
				setcookie('password', $infoUser['password'], time() + 365*24*3600, null, null, false, true);
			}
			else if ($cookied == 0)
			{
				// On efface les cookies par précaution
				setcookie('login','');
				setcookie('password','');			
			}
			
			header('location:index.php?src=success&log=logged');
			require('view/partial/modalView.php');
		}
	}
	else // Le pseudo n'existe pas on affiche le message d'erreur
	{
		header('location:index.php?src=logInError');
		require('view/partial/modalView.php');
	}
}

function userProfil()
{
	require('view/frontend/userProfilView.php');
}

function sessionUser($login)
{
	$userManager = new P4\model\UsersManager();
	$infoUser = $userManager->userInfos($login);
	
	$_SESSION['userId'] = $infoUser['ID'];
	$_SESSION['login'] = $infoUser['login'];
	$_SESSION['password'] = $infoUser['password'];
	$_SESSION['date_sign'] = $infoUser['date_sign'];
	$_SESSION['email'] = $infoUser['email'];
	$_SESSION['rule'] =  $infoUser['admin'];
	$_SESSION['country'] = $infoUser['country'];
	$_SESSION['avatar_path'] = $infoUser['avatar_path'];
}

function updatingUser($userId)
{
	// Vérifier les informations envoyer (faille XSS)
	// Vérifier la disponibilité des modifs
	// Lancer l'update du profil
	$userManager = new P4\model\UsersManager();
	
	// Test de toutes les valeurs
	
	// Test du pseudo ////////////////////////////////////////////////////////////////
	
	if(isset($_POST['pseudo'])&& strlen($_POST['pseudo'])!=0)
	{
		// Si le pseudo est renseigné, vérifié qu'il est différent de l'ancien et qu'il est libre et acceptable
		
		if(strlen($_POST['pseudo'])>3) // Le pseudo est assez long
		{
			if ($_POST['pseudo'] != $_SESSION['login']) // Le pseudo est différent de l'ancien
			{
				if($userManager->exists($_POST['pseudo'])) // Le pseudo est déjà utilisé
				{
					header('location:index.php?action=userProfil&error=usedpseudo');
					// Faire une modal pour l'erreur
				}
				else // Le pseudo est libre et valide on le sauvegarde juste dans la variable
				{
					$pseudo = htmlspecialchars($_POST['pseudo']);
				}
			}
			else
			{
				// Le pseudo n'a pas changé
				$pseudo = $_SESSION['login'];
			}
		}
		else
		{
			header('location:index.php?action=userProfil&error=shortpseudo');
			// faire une modal pour l'erreur
		}
	}
	else
	{
		$pseudo = $_SESSION['login']; // Pas de nouveau pseudo on conserve l'ancien
	} 
	// Fin du Test  ------  Le pseudo est testé /////////////////////////
	
	echo 'Le pseudo est : ' . $pseudo;
	
	// Test du mail ////////////////////////
	
	if(isset($_POST['email'])&& strlen($_POST['email'])!=0)
	{
		// Si le mail est renseigné, vérifié qu'il est différent de l'ancien, libre, et au bon format
		
		if ($_POST['email'] != $_SESSION['email']) // Le mail est différent de l'ancien
		{
			if ($userManager->existMail($_POST['email'])) // Le mail est déjà utilisé
			{
				header('location:index.php?action=userProfil&error=usedemail');
				// Faire une modal pour l'erreur
			}
			else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // Le mail est libre on vérifie son format
			{
				// Le mail n'est pas au bon format
				header('location:index.php?action=userProfil&error=patternemail');
				// Faire une modal pour l'erreur
			}
			else // Tout est bon pour l'email on le sauvegarde
			{
				$email = htmlspecialchars($_POST['email']);
			}
		}
		else
		{
			$email = $_SESSION['email'];
		}
	}
	else
	{
		$email = $_SESSION['email'];
	}
	// Fin du Test ---- Le mail est testé ////////////////////
	
	echo '<br/>le mail est : ' . $email;
	
	// Test des mots de passe ///////////////////////////////////
	
	if(isset($_POST['mdp1'])&& strlen($_POST['mdp1'])!=0 && isset($_POST['mdp2'])&& strlen($_POST['mdp2'])!=0 && isset($_POST['mdp3'])&& strlen($_POST['mdp3'])!=0)// Les 3 champs de mot de passe sont remplis
	{
		if ($_POST['mdp1'] != $_POST['mdp2'])
		{
			// Les mots de passe sont différents
			header('location:index.php?action=updateProfil&log=mirrorpassword');
			// Faire une modal pour l'erreur
		}
		else // Les mots de passe sont identiques, vérification du mot de passe de l'user
		{
			// Maintenant il faut comparer les mots de passes
			$isPasswordCorrect = password_verify($_POST['mdp2'], $_SESSION['password']);
			
			if($isPasswordCorrect) // C'est le bon mot de passe
			{
				if(strlen($_POST['mdp3'])>=6)// On vérifie la longueur du mdp3  et on le hash
				{
					$mdp3 = htmlspecialchars($_POST['mdp3']);
					$password = password_hash($mdp3, PASSWORD_DEFAULT);
				}
			}
			else
			{
				// Le mot de passe initial n'est pas le bon
				header('location:index.php?action=updateProfil&log=wrongpassword');
				// Faire une modal pour l'erreur
			}
		}
	}
	else
	{
		$password = $_SESSION['password'];
	}
	// Fin du test ----- Les mots de passe sont testés /////////////////
	
	echo '<br/>le password est : ' . $password;
	
	// Test du pays //////////////////////////////////
	if(isset($_POST['country'])&&strlen($_POST['country'])!=0)
	{
		$country = htmlspecialchars($_POST['country']);
	}
	else
	{
		$country = $_SESSION['country'];
	}
	// Fin du Test ----- Le pays est testé /////////////
	
	echo '<br/>le pays est : ' . $country;
	
	if ($_FILES['size']!= 0)
	{
		echo '<br/>il y a un fichier';
	}
	else
	{
		echo '<br/>pas de fichier';
	}
}
?>