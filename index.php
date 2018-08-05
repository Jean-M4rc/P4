<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// ----------- P4 ------- LE ROUTEUR DU SITE ------------------------ //
// ------------------------------------------------------------------ //

session_start();

//define('BASEPATH', __DIR__);



require 'model/PostsManager.php';
require 'model/CommentsManager.php';
require 'model/UsersManager.php';
require 'controller/BackEndController.php';
require 'controller/FrontEndController.php';
require 'vendor/autoload.php';

// Auto-loader -------------------------
//require 'vendor/Autoloader.php';
//Autoloader::register();

use P4\controller\FrontEndController;
use P4\controller\BackEndController;

// Routeur --------------

try {
	
	if(isset($_COOKIE['login'])&&!isset($_SESSION['login']))
	{
		FrontEndController::sessionUser($_COOKIE['login']);
	}
	
	if(isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case 'signOut':
				FrontEndController::signOut($_SESSION['userId']);
			break;
			
			case 'logOut':
				session_destroy();
				setcookie('login','');
				setcookie('password','');
				header('Location:http://localhost/P4/index.php');
				exit();
			break;
			
			case 'listPosts':
				FrontEndController::listPosts();
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
							FrontEndController::newUser($_POST['login'], $_POST['mdp1'], $_POST['mdp2'], $_POST['mail_user']);
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
						FrontEndController::logUser($_POST['pseudo'], $_POST['mdp'], 1);
					}
					else
					{
						FrontEndController::logUser($_POST['pseudo'], $_POST['mdp'], 0);
					}
				}
				else // L'un des champs est vide
				{
					throw new Exception('L\'identifiant ou le mot de passe n\'est pas valide !');
				}
			break;
			
			case 'userProfil':
				// On appelle le controlleur pour aller chercher les infos et la vue correspondante
				FrontEndController::userProfil();
			break;
			
			case 'updateProfil':
				// On lance le controleur en authentifiant le membre avec son id
				FrontEndController::updatingUser($_SESSION['userId']);
				FrontEndController::userProfil();
			break;
			
			case 'addNewPost':
				$post = $_POST['newPost'];
				$title = htmlspecialchars($_POST['postTitle']);
				BackEndController::newPost($title,$post);
			break;
			
			case 'pandOra':
				if (isset($_GET['target'])){
					switch ($_GET['target'])
					{
						case 'postCreate':
							BackEndController::createPostView();
						break;
						
						case 'postsEdit':
							BackEndController::postsBackView();
						break;
						
						case 'commentsEdit':
							BackEndController::commentsEdit();
						break;
						
						case 'updatePost':
							BackEndController::updatePost($_POST['postID'],$_POST['postTitle'],$_POST['postContent']);
						break;
						
						case 'deletePost':
							BackEndController::deletePost($_POST['postID']);
						break;
						
						case 'usersEdit':
							BackEndController::usersEdit();
						break;
						
						case 'initAvatar':
							BackEndController::initAvatar($_POST['userID']);
						break;

						case 'upgradeUser':
							BackEndController::upgradeUser($_POST['admin'],$_POST['userID']);
						break;
						
						case 'banUser':
							BackEndController::banUser($_POST['admin'], $_POST['userID'], $_POST['ban']);
						break;
						
						default:
							BackEndController::adminHome();
						break;
					}
				}
				else
				{
					BackEndController::adminHome();
				}
			break;
			
			case 'post':
				if(isset($_GET['id']))
				{
					FrontEndController::post($_GET['id']);
				}
				else
				{
					throw new Exception('Le post n\'est pas sélectionné !');
				}
			break;
			
			case 'addComment':
				if(isset($_POST['comment']) && isset($_POST['postId']) && isset($_POST['autorId']))
				{
					BackEndController::addComment($_POST['comment'],$_POST['postId'],$_POST['autorId']);
				}
				else
				{
					throw new Exception('Le commentaire ne peut pas être ajouté !');
				}
			
			break;
			
			case 'reportCom':
				if(isset($_POST['comment_id']) && isset($_POST['post_id']) && isset($_POST['report']) && ($_POST['report']==1))
				{
					BackEndController::reportComment($_POST['comment_id'], $_POST['post_id']);
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
								BackEndController::reportCommentAdmin($_POST['comment_id'],$_POST['comment_report']);
							}
							else
							{
								throw new Exception('ils manquent des infos pour le signalement');
							}
						break;
						
						case 'moderation':
							if(isset($_POST['comment_id']) && isset($_POST['comment_moderation']))
							{
								BackEndController::moderationComment($_POST['comment_id'],$_POST['comment_moderation']);
							}
							else
							{
								throw new Exception('ils manquent des infos pour la modération');
							}						
						break;
						
						case 'delete':
							if(isset($_POST['comment_id']))
							{
								BackEndController::deleteComment($_POST['comment_id']);
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
				FrontEndController::usersList();
			break;
			
			default :
				FrontEndController::homepage();
			break;
		}
	}
	else
	{
		FrontEndController::homepage();
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