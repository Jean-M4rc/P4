<?php

// ---------------------------------------------------------------------- //
// --------- P4 --------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //


// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');

// Le controlleur front-end va proposer les différentes fonctions nécessaires pour les vues publiques.
// je dois créer une classe controler et ensuite faire deux objets, une classe FrontControler et une classe BackendControler

function homePage()
{
	require('view/frontend/homepageView.php');
}

function listPosts() // Première fonction de base listPosts() qui affiche tout les billets de la bdd
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
	else if (strlen($mdp2)<=5) // Test de la longueur du mot de passe
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
	
	// Test de l'image et redimensionnement pour pouvoir être afficher en fenêtre ////////////
	
	if (!empty($_FILES['userImage']))
	{
		if ($_FILES['userImage']['error'] <= 0)
		{
			if ($_FILES['userImage']['size'] <= 2097152)
			{	
				$userImage = $_FILES['userImage']['name'];
				
				echo '<br/>le nom du fichier est : ' . $userImage;
				
				// On défini les extensions acceptées
				$ListeExtension = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif');
				$ListeExtensionIE = array('jpg' => 'image/pjpg', 'jpeg'=>'image/pjpeg');
				
				// On cherche l'extension du fichier
				$ExtensionPresumee = explode('.', $userImage);
				$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
				
				if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg' || $ExtensionPresumee == 'pjpg' || $ExtensionPresumee == 'pjpeg' || $ExtensionPresumee == 'gif' || $ExtensionPresumee == 'png') // L'extension est valide
				{
					$userImage = getimagesize($_FILES['userImage']['tmp_name']);
				
					if ($userImage['mime'] == $ListeExtension[$ExtensionPresumee]  || $userImage['mime'] == $ListeExtensionIE[$ExtensionPresumee])
					{
						// Ici nous allons procéder au redimensionnement, nous devons récrire ce block pour les 2 autres format gif et png
						if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg')
						{
							echo '<br/>le format MIME est jpg';
							$newUserImage = imagecreatefromjpeg($_FILES['userImage']['tmp_name']);
						}
						else if ($userImage['mime'] == 'image/png')
						{
							echo '<br/>le format MIME est png';
							$newUserImage = imagecreatefrompng($_FILES['userImage']['tmp_name']);
						}
						else if ($userImage['mime'] == 'image/gif')
						{
							echo '<br/>le format MIME est gif';
							$newUserImage = imagecreatefromgif($_FILES['userImage']['tmp_name']);
						}
						else
						{
							echo '<br/>le type MIME ne correspond pas';
						}
						
						// Nous avons créé la nouvelle image en fonction de son extension nous poursuivons le traitement
						$sizeNewUserImage = getimagesize($_FILES['userImage']['tmp_name']);
						// On détermine le ratio 
						$newWidth = 100;
						$Reduction = (($newWidth * 100) / $sizeNewUserImage[0]);
						$newHeight = (($sizeNewUserImage[1] * $Reduction)/100);
						$userAvatar = imagecreatetruecolor($newWidth, $newHeight) or die ("Erreur");
						imagecopyresampled($userAvatar, $newUserImage, 0, 0, 0, 0, $newWidth, $newHeight, $sizeNewUserImage[0], $sizeNewUserImage[1]);
						imagedestroy($newUserImage);
						
						if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg')
						{
							echo '<br/>on crée un jpg';
							imagejpeg($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);
						}
						else if ($userImage['mime'] == 'image/png')
						{
							echo '<br/>on crée un png';
							imagepng($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 6);
						}
						else if ($userImage['mime'] == 'image/gif')
						{
							echo '<br/>on crée un gif';
							imagegif($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);
						}

						$avatar_path = 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee;
						echo '<br/>' . $avatar_path;
					}
					else
					{
						echo '<br/> Le type MIME n\'est pas bon';
					}
				}
				else
				{
					echo '<br/>l\'extension du fichier n\'est pas valide';
				}
			}
			else
			{
				echo '<br/>L\'image est trop grande';
			}
		}
		else
		{
			echo '<br/>le téléchargement a rencontré une erreur. Code erreur : ' . $_FILES['userImage']['error'];
		}
	}
	else
	{
		echo '<br/>pas de fichier envoyé';
		$avatar_path = $_SESSION['avatar_path'];
	}
}
?>