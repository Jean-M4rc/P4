<?php

// ---------------------------------------------------------------------- //
// --------- P4 --------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //

namespace P4\controller;

//require_once('controller\Controller.php');
// Chargement des classes du model
//require_once('model/PostsManager.php');
//require_once('model/CommentsManager.php');
//require_once('model/UsersManager.php');

// Le controlleur front-end va proposer les différentes fonctions nécessaires pour les vues publiques.
class FrontEndController extends Controller{

	public static function homePage(){
		require('view/frontend/homepageView.php');
	}

	public static function listPosts(){// Première fonction de base listPosts() qui affiche tout les résumés de billets de la bdd
		$postsManager = new P4\model\PostsManager(); // Création d'un objet à partir de la classe. Utilisation du namespace
		$posts = $postsManager->getPosts(); // Appel d'une méthode de cette classe pour cet objet.
		require('view/frontend/ListPostsView.php'); // Appel de la vue correspondante.
	}

	public static function post($id){
		$postsManager = new P4\model\PostsManager();
		if ($postsManager->existsID($id))
		{
			// Si l'id est valide on affiche le post
			$post = $postsManager->getPost($id);
			$commentsManager = new P4\model\CommentsManager();
			$comments = $commentsManager->getComments($id);
			require('view/frontend/postView.php');
		}
		else
		{
			echo 'le post n\'existe pas';
		}
	}

	public static function newUser($login, $mdp1, $mdp2, $email){	
		// Vérouillage des failles XSS
		$login = htmlspecialchars($_POST['login']);
		$mdp1 = htmlspecialchars($_POST['mdp1']);
		$mdp2 = htmlspecialchars($_POST['mdp2']);
		$email = htmlspecialchars($_POST['mail_user']);

		// On instance un nouveau manager d'utilisateur pour appliquer ses fonctions
		$userManager = new P4\model\UsersManager();
		$adress = $_SERVER['HTTP_REFERER'];
		if (($adress == 'http://localhost/P4/index.php') || $adress == 'http://localhost/P4/')
		{
			$adress = 'http://localhost/P4/index.php?';
		}
		else
		{
			$adress = $_SERVER['HTTP_REFERER'] . '&';
		}
		
		if ($userManager->exists($login))
		{
			// Si cette condition est vraie le pseudo est déjà utilisé
			header('location:' . $adress . 'src=signformError&log=loginused');
			require('view/partial/modalView.php');
		}
		else if (strlen($login)<3)
		{
			header('location:' . $adress . 'src=signformError&log=loginshort');
			require('view/partial/modalView.php');
		}
		else if ($mdp1 != $mdp2) //Test du mot de passe identiques
		{
			header('location:' . $adress . 'src=signformError&log=passwordmirror');
			require('view/partial/modalView.php');
		}
		else if (strlen($mdp2)<=5) // Test de la longueur du mot de passe
		{
			header('location:' . $adress . 'src=signformError&log=passwordshort');
			require('view/partial/modalView.php');
		}
		else if ($userManager->existMail($email)) // Test de l'unicité de l'email
		{
			header('location:' . $adress . 'src=signformError&log=mailused');
			require('view/partial/modalView.php');
			
		}
		else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) // Test de la Regex sur l'email
		{
			header('location:' . $adress . 'src=signformError&log=mailmirror');
			require('view/partial/modalView.php');
		}
		else //Tout les test sont bons, ont hache le mdp et on insert
		{ 
			$password = password_hash($mdp2, PASSWORD_DEFAULT);
			$affectedUser = $userManager->addNewUser($login, $password, $email);
			$_SESSION['login'] = $login;
			sessionUser($_SESSION['login']);
			header('location:' . $adress .'src=signformSuccess&log=signed');
			require('view/partial/modalView.php');
		}
	}

	public static function logUser($login, $password, $cookied){
		// Vérouillage des failles XSS
		$login = htmlspecialchars($_POST['pseudo']);
		$password = htmlspecialchars($_POST['mdp']);
		
		$userManager = new P4\model\UsersManager();
		
		$adress = $_SERVER['HTTP_REFERER'];
		if (($adress == 'http://localhost/P4/index.php') || $adress == 'http://localhost/P4/')
		{
			$adress = 'http://localhost/P4/index.php?';
		}
		else
		{
			$adress = $_SERVER['HTTP_REFERER'] . '&';
		}
		
		// On appelle la méthode pour savoir si ce pseudo existe
		if ($userManager->exists($login)){
			
			// true => on va chercher les infos dans la bdd
			$infoUser = $userManager->userInfos($login);
			
			// Maintenant il faut comparer les mots de passes
			$isPasswordCorrect = password_verify($password, $infoUser['password']);

			if ($isPasswordCorrect)
			{
				if($infoUser['ban']==1)
				{
					header('location:' . $adress .'src=userBanned');
					require('view/partial/modalView.php');
				}
				else
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
				header('location:' . $adress .'src=success&log=logged');
				require('view/partial/modalView.php');
				}
			}
			else
			{
				header('location:' . $adress . 'src=logInError');
				require('view/partial/modalView.php');
			}
		}
		else // Le pseudo n'existe pas on affiche le message d'erreur
		{
			header('location:' . $adress . 'src=logInError');
			require('view/partial/modalView.php');
		}
	}

	public static function userProfil(){
		require('view/frontend/userProfilView.php');
	}

	public static function sessionUser($login){
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

	public static function updatingUser($userId) // Mise à jour des informations de l'utilisateur
	{
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
						header('location:index.php?action=userProfil&error=loginused');
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
				header('location:index.php?action=userProfil&error=loginshort');
			}
		}
		else
		{
			$pseudo = $_SESSION['login']; // Pas de nouveau pseudo on conserve l'ancien
		} 
		// Fin du Test  ------  Le pseudo est testé /////////////////////////
		
		// Test du mail ////////////////////////
		
		if(isset($_POST['email'])&& strlen($_POST['email'])!=0)
		{
			// Si le mail est renseigné, vérifié qu'il est différent de l'ancien, libre, et au bon format
			
			if ($_POST['email'] != $_SESSION['email']) // Le mail est différent de l'ancien
			{
				if ($userManager->existMail($_POST['email'])) // Le mail est déjà utilisé
				{
					header('location:index.php?action=userProfil&error=mailused');
					// Faire une modal pour l'erreur
				}
				else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // Le mail est libre on vérifie son format
				{
					// Le mail n'est pas au bon format
					header('location:index.php?action=userProfil&error=mailmirror');
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
		
		// Test des mots de passe ///////////////////////////////////
		
		if(isset($_POST['mdp1'])&& strlen($_POST['mdp1'])!=0 && isset($_POST['mdp2'])&& strlen($_POST['mdp2'])!=0 && isset($_POST['mdp3'])&& strlen($_POST['mdp3'])!=0)// Les 3 champs de mot de passe sont remplis
		{
			if ($_POST['mdp1'] != $_POST['mdp2'])
			{
				// Les mots de passe sont différents
				header('location:index.php?action=userProfil&error=passwordmirror');
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
					else
					{
						// Le mot de passe est trop court
						header('location:index.php?action=userProfil&error=passwordshort');
					}
				}
				else
				{
					// Le mot de passe initial n'est pas le bon
					header('location:index.php?action=userProfil&error=passwordwrong');
				}
			}
		}
		else
		{
			$password = $_SESSION['password'];
		}
		// Fin du test ----- Les mots de passe sont testés /////////////////
		
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
		
		// Test de l'image et redimensionnement pour pouvoir être afficher en fenêtre ////////////
		if (isset($_POST['deleteUserAvatar']))
		{
			$avatar_path = 'public/images/user_avatar/0.jpeg';
		}
		else if (isset($_FILES['userImage']) && !empty($_FILES['userImage']))
		{
			if ($_FILES['userImage']['error'] == 0)
			{
				if ($_FILES['userImage']['size'] <= 2097152)
				{	
					$userImage = $_FILES['userImage']['name'];
					
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
								$newUserImage = imagecreatefromjpeg($_FILES['userImage']['tmp_name']);
							}
							else if ($userImage['mime'] == 'image/png')
							{
								$newUserImage = imagecreatefrompng($_FILES['userImage']['tmp_name']);
							}
							else if ($userImage['mime'] == 'image/gif')
							{
								$newUserImage = imagecreatefromgif($_FILES['userImage']['tmp_name']);
							}
							else
							{
								//le type MIME ne correspond pas
								header('location:index.php?action=userProfil&error=imagewrong');
							}
							
							// Nous avons créé la nouvelle image en fonction de son extension nous poursuivons le traitement
							$sizeNewUserImage = getimagesize($_FILES['userImage']['tmp_name']);
							
							// On détermine le ratio si la dimension la plus grande
		
							$width = $sizeNewUserImage[0];
							$height = $sizeNewUserImage[1];
							$avatarSide = 75;
							if ($width >= $height)
							{
								$newWidth = $avatarSide;
								$Reduction = (($newWidth * 100) / $width);
								$newHeight = (($height * $Reduction)/100);
							}
							else if ($height > $width)
							{
								$newHeight = $avatarSide;
								$Reduction = (($newHeight * 100) / $height);
								$newWidth = (($width * $Reduction)/100);
							}
							
							$userAvatar = imagecreatetruecolor($newWidth, $newHeight) or die ("Erreur");
							imagecopyresampled($userAvatar, $newUserImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
							imagedestroy($newUserImage);

							
							if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg')
							{
								imagejpeg($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);
							}
							else if ($userImage['mime'] == 'image/png')
							{
								imagepng($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 6);
							}
							else if ($userImage['mime'] == 'image/gif')
							{
								imagegif($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);
							}

							$avatar_path = 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee;
						}
						else
						{
							// Le type MIME n'est pas bon
							header('location:index.php?action=userProfil&error=imagewrong');
						}
					}
					else
					{
						// l'extension du fichier n'est pas valide
						header('location:index.php?action=userProfil&error=imagewrong');
					}
				}
				else
				{
					// L'image est trop grande
					header('location:index.php?action=userProfil&error=imagesize');
				}
			}
			else if ($_FILES['userImage']['error'] == 4)// Le code erreur 4 signifie pas de fichier
			{
				// Pas de fichier donc on garde l'ancien chemin
				$avatar_path = $_SESSION['avatar_path'];
			}
			else
			{
				// Le téléchargement a rencontré une erreur.
				header('location:index.php?action=userProfil&error=uploaderror');
			}
		}
		else
		{
			// Pas de fichier envoyé -- partie probablement inutile
			$avatar_path = $_SESSION['avatar_path'];
		}
		
		
		//Maintenant toutes les valeurs sont testés on peut lancer la requete d'upload avec tout les paramètres
		$userManager->updateUserInfo($_SESSION['userId'], $pseudo, $email, $password, $country, $avatar_path);
		sessionUser($pseudo);
		header('location:index.php?action=userProfil&success=true');
		// Faire la modal de succès
	}

	public static function signOut($userId){
		$password = htmlspecialchars($_POST['password']);
		
		$isPasswordCorrect = password_verify($password, $_SESSION['password']);

			if ($isPasswordCorrect)
			{
				// On peut effacer l'entrée du membre
				$userManager = new P4\model\UsersManager();
				$userManager->deleteUser($_SESSION['userId']);
				
				// On efface les cookies et on détruit la session
				session_destroy();
				setcookie('login','');
				setcookie('password','');
				header('Location:index.php');
			}
			else
			{
				$adress = $_SERVER['HTTP_REFERER'];
				
				if (($adress == 'http://localhost/P4/index.php') || $adress == 'http://localhost/P4/')
				{
					$adress = 'http://localhost/P4/index.php?';
				}
				else
				{
					$adress = $_SERVER['HTTP_REFERER'] . '&';
				}
				
				header('location:' . $adress . 'action=userProfil&log=signOutError');
			}
	}

	public static function usersList(){
		$userManager = new P4\model\UsersManager();
		$users = $userManager->usersList();
		require('view/frontend/usersListView.php');
	}
}