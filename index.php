<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// ----------- P4 ------- LE ROUTEUR DU SITE ------------------------ //
// ------------------------------------------------------------------ //

// On appelle session_start() APRES avoir enregistré l'autoload.
session_start();
// Ici c'est le routeur, comme adresse de base 
// je veux afficher une page d'accueil graphique épurée très nature

// Auto-loader -------------------------
require_once('vendor/autoloadhome.php');
require_once('vendor/autoload.php');
require_once('controller/frontend.php');
require_once('controller/backend.php');

// Routeur --------------

try {
	
	if(isset($_GET['action']))
	{
		if($_GET['action']== 'logOut') // D'abord on écoute la déconnexion
		{
			session_destroy();
			header('Location: .');
			exit();
		}
		else if($_GET['action']== 'listPosts')
		{
			listPosts();
		}
		else if($_GET['action']== 'signin') //inscription au blog
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