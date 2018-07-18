<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// ----------- P4 ------- LE ROUTEUR DU SITE ------------------------ //
// ------------------------------------------------------------------ //

session_start();

//define('BASEPATH', __DIR__);

// Auto-loader -------------------------
require 'vendor/Autoloader.php';
require 'controller/BackEndController.php';
require 'controller/FrontEndController.php';

//Autoloader::register();

use P4\controller;
use P4\model;

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
			break;
			
			case 'logOut':
				session_destroy();
				setcookie('login','');
				setcookie('password','');
				header('Location:http://localhost/P4/index.php');
				exit();
			break;
			
			case 'listPosts':
				P4\controller\FrontEndController::listPosts();
			break;
			
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
			break;
			
			case 'login':
				if (!empty($_POST['pseudo']) && !empty($_POST['mdp']))
				{
					if (isset($_POST['CA']))
					{
						P4\controller\FrontEndController::logUser($_POST['pseudo'], $_POST['mdp'], 1);
					}
					else
					{
						P4\controller\FrontEndController::logUser($_POST['pseudo'], $_POST['mdp'], 0);
					}
				}
				else // L'un des champs est vide
				{
					throw new Exception('L\'identifiant ou le mot de passe n\'est pas valide !');
				}
			break;
			
			case 'userProfil':
				// On appelle le controlleur pour aller chercher les infos et la vue correspondante
				userProfil();
			break;
			
			case 'updateProfil':
				// On lance le controleur en authentifiant le membre avec son id
				updatingUser($_SESSION['userId']);
				userProfil();
			break;
			
			case 'addNewPost':
				$post = $_POST['newPost'];
				$title = htmlspecialchars($_POST['postTitle']);
				newPost($title,$post);
			break;
			
			case 'pandOra':
				if (isset($_GET['target'])){
					switch ($_GET['target'])
					{
						case 'postCreate':
							P4\controller\BackEndController::createPostView();
						break;
						
						case 'postsEdit':
							P4\controller\BackEndController::postsBackView();
						break;
						
						case 'commentsEdit':
							P4\controller\BackEndController::commentsEdit();
						break;
						
						case 'updatePost':
							P4\controller\BackEndController::updatePost($_POST['postID'],$_POST['postTitle'],$_POST['postContent']);
						break;
						
						case 'deletePost':
							P4\controller\BackEndController::deletePost($_POST['postID']);
						break;
						
						case 'usersEdit':
							P4\controller\BackEndController::usersEdit();
						break;
						
						case 'initAvatar':
							P4\controller\BackEndController::initAvatar($_POST['userID']);
						break;

						case 'upgradeUser':
							P4\controller\BackEndController::upgradeUser($_POST['admin'],$_POST['userID']);
						break;
						
						case 'banUser':
							P4\controller\BackEndController::banUser($_POST['admin'], $_POST['userID'], $_POST['ban']);
						break;
						
						default:
							P4\controller\BackEndController::adminHome();
						break;
					}
				}
				else
				{
					P4\controller\BackEndController::adminHome();
				}
			break;
			
			case 'post':
				if(isset($_GET['id']))
				{
					P4\controller\FrontEndController::post($_GET['id']);
				}
				else
				{
					throw new Exception('Le post n\'est pas sélectionné !');
				}
			break;
			
			case 'addComment':
				if(isset($_POST['comment']) && isset($_POST['postId']) && isset($_POST['autorId']))
				{
					addComment($_POST['comment'],$_POST['postId'],$_POST['autorId']);
				}
				else
				{
					throw new Exception('Le commentaire ne peut pas être ajouté !');
				}
			
			break;
			
			case 'reportCom':
				if(isset($_POST['comment_id']) && isset($_POST['post_id']) && isset($_POST['report']) && ($_POST['report']==1))
				{
					reportComment($_POST['comment_id'], $_POST['post_id']);
				}
				else
				{
					throw new Exception('Le commentaire ne peut pas être signalé !');
				}
			break;
			
			case 'CommentEdit':
				if (isset($_GET['tag'])){
					switch ($_GET['tag'])
					{
						case 'reportComment':
							if(isset($_POST['comment_id']) && isset($_POST['comment_report']))
							{
								reportCommentAdmin($_POST['comment_id'],$_POST['comment_report']);
							}
							else
							{
								throw new Exception('ils manquent des infos pour le signalement');
							}
						break;
						
						case 'moderation':
							if(isset($_POST['comment_id']) && isset($_POST['comment_moderation']))
							{
								moderationComment($_POST['comment_id'],$_POST['comment_moderation']);
							}
							else
							{
								throw new Exception('ils manquent des infos pour la modération');
							}						
						break;
						
						case 'delete':
							if(isset($_POST['comment_id']))
							{
								deleteComment($_POST['comment_id']);
							}
							else
							{
								throw new Exception('ils manquent des infos pour la suppression');
							}
						break;
						
					}
				}
			break;
			
			case 'usersList':
				usersList();
			break;
			
			default :
				P4\Controller\FrontEndController::homepage();
			break;
		}
	}
	else
	{
		P4\Controller\FrontEndController::homepage();
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