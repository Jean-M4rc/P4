<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// ----------- P4 ------- LE ROUTEUR DU SITE ------------------------ //
// ------------------------------------------------------------------ //

session_start();

// Auto-loader -------------------------
//require_once('vendor/autoloadhome.php');

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
		switch ($_GET['action'])
		{
			case 'signOut':
				signOut($_SESSION['userId']);
			Break;
			
			case 'logOut':
				session_destroy();
				setcookie('login','');
				setcookie('password','');
				header('Location:http://localhost/P4/index.php');
				exit();
			Break;
			
			case 'listPosts':
				listPosts();
			Break;
			
			case 'signin':
				if(!empty($_POST['g-recaptcha-response'])) // On vérifie si le captcha est rempli
				{
					$recaptcha = new \ReCaptcha\ReCaptcha('6LcRllwUAAAAAMjUbssUHjzFQ8Pyl65Nm-bo1SvL');
					$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
					
					if ($resp->isSuccess()) // On vérifie si le captcha non vide est bon
					{ //s'il est bon on vérifie la présence de tout les champs
						if (!empty($_POST['login']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2']) && !empty($_POST['mail_user']))
						{
							// On appelle la méthode newUser du controleur pour vérifier et appeller le model et vérifier les données
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
			Break;
			
			case 'login':
				if (!empty($_POST['pseudo']) && !empty($_POST['mdp']))
				{
					if (isset($_POST['CA'])) // Connexion automatique ou pas
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
			Break;
			
			case 'userProfil':
				// On appelle le controlleur pour aller chercher les infos et la vue correspondante
				userProfil();
			Break;
			
			case 'updateProfil':
				// On lance le controleur en authentifiant le membre avec son id
				updatingUser($_SESSION['userId']);
				userProfil();
			Break;
			
			case 'addNewPost':
				$post = $_POST['newPost'];
				$title = htmlspecialchars($_POST['postTitle']);
				newPost($title,$post);
			Break;
			
			case 'pandOra':
				if (isset($_GET['target'])){
					switch ($_GET['target'])
					{
						case 'postsEdit':
							postsBackView();
						Break;
						
						case 'updatePost':
							updatePost($_POST['postID'],$_POST['postTitle'],$_POST['postContent']);
						Break;
						
						case 'deletePost':
							deletePost($_POST['postID']);
						Break;
						
						default:
							adminHome();
						Break;
					}
				}
				else
				{
					adminHome();
				}
			Break;
			
			case 'post':
				if(isset($_GET['id']))
				{
					post($_GET['id']);
				}
				else
				{
					require('view/partial/modalView.php');
				}
			Break;
			
			case 'addComment':
				if(isset($_POST['comment']) && isset($_POST['postId']) && isset($_POST['autorId']))
				{
					addComment($_POST['comment'],$_POST['postId'],$_POST['autorId']);
				}
				else
				{
					throw new Exception('Le commentaire ne peut pas être ajouté !');
				}
			
			Break;
			
			default :
				homepage();
			Break;
		}
	}
	else
	{
		homepage();
	}

}
catch(Exception $e){
	
	$msgError = $e->getMessage();
	$adress = $_SERVER['HTTP_REFERER'];
	
	if (($adress == 'http://localhost/P4/index.php') || $adress == 'http://localhost/P4/')
	{
		$adress = 'http://localhost/P4/index.php?';
	}
	else
	{
		$adress = $_SERVER['HTTP_REFERER'] . '&';
	}
	
	header('Location:' . $adress . 'Exception=' .$msgError.'');
	require('view/partial/modalView.php');
	
}
?> 