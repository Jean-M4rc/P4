<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// ----------- P4 ------- LE ROUTEUR DU SITE ------------------------ //
// ------------------------------------------------------------------ //

session_start();

// Auto-loader -------------------------

require_once('vendor/autoloadhome.php');
require_once('vendor/autoload.php');
require_once('controller/frontend.php');
require_once('controller/backend.php');

// Routeur --------------

try {
	
	if(isset($_COOKIE['login'])&&!isset($_SESSION['login'])) // Si le cookie existe mais que la session n'existe pas
	{
		sessionUser($_COOKIE['login']);
	}
		
	if(isset($_GET['action']))
	{
		if($_GET['action']== 'signOut')
		{
			signOut($_SESSION['userId']);
		}
		else if($_GET['action']== 'logOut') // Déconnexion
		{
			session_destroy();
			setcookie('login','');
			setcookie('password','');
			header('Location: .');
			exit();
		}
		else if($_GET['action']== 'listPosts') // Afficher les billets
		{
			listPosts();
		}
		else if($_GET['action']== 'signin') // Inscription au blog
		{
			if(!empty($_POST['g-recaptcha-response'])) // On vérifie si le captcha est rempli
			{
				$recaptcha = new \ReCaptcha\ReCaptcha('6LcRllwUAAAAAMjUbssUHjzFQ8Pyl65Nm-bo1SvL');
				$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
				
				if ($resp->isSuccess()) // On vérifie si le captcha non vide est bon
				{ //s'il est bon on vérifie la présence de tout les champs
					if (!empty($_POST['login']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2']) && !empty($_POST['mail_user']))
					{
						// On appelle la méthode newUser du controler pour vérifier appeller le model et vérifier les données
						newUser($_POST['login'], $_POST['mdp1'], $_POST['mdp2'], $_POST['mail_user']);
					}
					else // L'un des champs est vide
					{
						throw new Exception('Tous les champs ne sont pas remplis !');
					}
				}
				else // Le captcha est faux
				{
					throw new Exception('Le captcha est invalide');
				}
			}
			else // Le captcha est vide
			{
				throw new Exception('Le captcha est n\'est pas rempli');
			}
		}
		else if ($_GET['action']== 'login') // Connexion en tant que membre
		{
			if (!empty($_POST['pseudo']) && !empty($_POST['mdp']))
			{
				if (isset($_POST['CA']))
				{
					// 1 = setcookies
					logUser($_POST['pseudo'], $_POST['mdp'], 1);
				}
				else
				{
					// 0 = !setcookies
					logUser($_POST['pseudo'], $_POST['mdp'], 0);
				}
			}
			else // L'un des champs est vide
			{
				throw new Exception('L\'identifiant ou le mot de passe n\'est pas valide !');
			}
		}
		else if ($_GET['action']== 'userProfil') // Modification des infos du membre
		{
			// On appelle le controlleur pour aller chercher les infos et la vue correspondante
			userProfil();
		}
		else if ($_GET['action']== 'updateProfil') // Mise à jour du profil
		{
			// On lance le controleur en authentifiant le membre avec son id
			updatingUser($_SESSION['userId']);
			userProfil();
		}
		else
		{
			homepage();
		}
	}
	else
	{
		homepage();
	}
}
catch(Exception $e){
	
	$msgError = $e->getMessage();
	header('Location:index.php?Exception=' .$msgError.'');
	require('view/partial/modalView.php');
}
?> 