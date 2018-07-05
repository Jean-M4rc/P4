<?php

// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');


function adminHome()
{
	require('view/backend/homeAdminView.php');
}

function createPostView()
{
	require('view/backend/createPostView.php');
}

function newPost($title,$post)
{
	if (isset($post) && is_string($post) && !empty($post) && isset($title) && is_string($title))
	{
		// On crée un résumé du récit
		$resume = strip_tags(substr($post,0,300) . '...','<br>');
		// On peut appeler le model et la vue pour sauvegarder ce nouveau récit
		$postsManager = new P4\model\PostsManager();
		$postsManager->addPost($title, $post, $resume);
		header('location:index.php?action=pandOra&log=successPost');
	}
	else
	{
		header('location:index.php?action=pandOra&log=errorPost');
	}
}

function postsBackView()
{
	$postsManager = new P4\model\PostsManager();
	$posts = $postsManager->getPosts();
	require('view/backend/postsEditView.php');
	
}

function updatePost($postID, $postTitle, $postContent)
{
	// On controle les valeurs et on update
	$postManager = new P4\model\PostsManager;
	
	// Test d'un Id valide
	if (is_numeric($postID))
	{
		if ($postManager->existsID($postID))
		{
			if (!empty($postTitle) && strlen($postTitle)>5 && is_string($postTitle))
			{
				if(!empty($postContent) && strlen($postContent)>20 && is_string($postContent))
				{
					$postManager->updatePost($postID, $postTitle, $postContent);
					header('location:index.php?action=pandOra&target=postsEdit&log=successpostup');					
				}
				else
				{
					header('location:index.php?action=pandOra&target=postsEdit&log=errorpostup');
				}
			}
			else
			{
				header('location:index.php?action=pandOra&target=postsEdit&log=errorpostup');
			}
		}
		else
		{
			header('location:index.php?action=pandOra&target=postsEdit&log=errorpostup');
		}
	}
	else
	{
		header('location:index.php?action=pandOra&target=postsEdit&log=errorpostup');
	}	
}

function deletePost($postID) // On doit aussi supprimer les commentaires du post en question
{
	$postManager = new P4\model\PostsManager;
	
	if (is_numeric($postID) && $postManager->existsID($postID))
	{
		$postManager->deletePost($postID);
		header('location:index.php?action=pandOra&target=postsEdit&postdown=success');
	}
	else
	{
		header('location:index.php?action=pandOra&target=postsEdit&postdown=fail');
	}
}

function addComment($comment,$postId,$autorId)
{
	//Test des valeurs $comment, de l'existence de postid et de autorId
	$comment = nl2br(htmlspecialchars($comment));
	
	$postManager = new P4\model\PostsManager();
	if ($postManager->existsID($postId))
	{
		$userManager = new P4\model\UsersManager();
		if (($userManager->exists($autorId)))
		{
			$commentManager = new P4\model\CommentsManager();
			$commentManager->addComment($postId, $autorId, $comment);
			header('location:index.php?action=post&id=' . $postId .'#comments');
		}
		else
		{
			echo $postId;
			echo $autorId;
			echo 'Le compte utilisateur est erroné';
			
		}
	}
	else
	{
		echo $postId;
		echo $autorId;
		echo 'Le postId n\'existe pas';
	}
}

function reportComment($id, $postId)
{
	// test de l'existence du com
	$commentManager = new P4\model\CommentsManager();
	if ($commentManager->existsID($id))
	{
		// update du report
		$commentManager->reportComment($id,1);
		header('location:index.php?action=post&id=' . $postId .'&report=success');
	}
	else
	{
		header('location:index.php?action=post&id=' . $postId .'&report=fail');
	}
}

function reportCommentAdmin($comment_id,$report)
{
	// test de l'existence du com
	$commentManager = new P4\model\CommentsManager();
	if ($commentManager->existsID($comment_id))
	{
		// update du report
		if ($report == 1) // On lève le signalement
		{
			$report=0;
			$commentManager->reportComment($comment_id,$report);
			header('location:index.php?action=pandOra&target=commentsEdit');
			
		}
		else if ($report == 0) // On signale le commentaire
		{
			$report=1;
			$commentManager->reportComment($comment_id,$report);
			header('location:index.php?action=pandOra&target=commentsEdit');
		}
		else
		{
			echo 'la valeur $report n\'est pas correcte';
		}
		
	}
	else
	{
		echo 'l\'id du com n\'est pas bonne';
	}
}

function moderationComment($comment_id, $moderation)
{
	// test de l'existence du com
	$commentManager = new P4\model\CommentsManager();
	if ($commentManager->existsID($comment_id))
	{
		// update du report
		if ($moderation == 1) // On lève la modération
		{
			$moderation=0;
			$commentManager->moderateComment($comment_id,$moderation);
			header('location:index.php?action=pandOra&target=commentsEdit');
			
		}
		else if ($moderation == 0) // On signale le commentaire
		{
			$moderation=1;
			$commentManager->moderateComment($comment_id,$moderation);
			header('location:index.php?action=pandOra&target=commentsEdit');
		}
		else
		{
			echo 'la valeur $moderation n\'est pas correcte';
		}
		
	}
	else
	{
		echo 'l\'id du com n\'est pas bonne';
	}
}

function deleteComment($comment_id)
{
	echo 'on est dans le controlleur back dans reportcommentadmin';
	// test de l'existence du com
	$commentManager = new P4\model\CommentsManager();
	if ($commentManager->existsID($comment_id))
	{
		$commentManager->deletComment($comment_id);
		header('location:index.php?action=pandOra&target=commentsEdit');
	}
	else
	{
		echo 'l\'id du com n\'est pas bonne';
	}
}

function commentsEdit() // ici il faut ajouter la jointure autor_id nom de l'autor et la requete de récit pour afficher les noms de récits dans le filtres
{
	$commentManager = new P4\model\CommentsManager();
	$com = $commentManager->getAllComments(); 
	require('view/backend/commentsEditView.php');	
}

function usersEdit()
{
	$usersManager = new P4\model\UsersManager();
	$users = $usersManager->listUsers();
	require('view/backend/usersEditView.php');
}

function initAvatar($userId)
{
	if(is_numeric($userId))
	{
		$usersManager = new P4\model\UsersManager();
		if ($users = $usersManager->exists($userId))
		{
			$users = $usersManager->initAvatarPath($userId);
			header('location:index.php?action=pandOra&target=usersEdit');
		}
		else
		{
			echo 'l\'id n\'existe pas';
		}
	}
	else
	{
		echo 'la valeur envoyé n\'est pas un chiffre';
	}	
}

function upgradeUser($admin,$userId)
{
	$adminArray = array('0','1','2');
	if(isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin,$adminArray))
	{
		
		$usersManager = new P4\model\UsersManager();
		if ($users = $usersManager->exists($userId))
		{
			$users = $usersManager->upgradeUser($admin,$userId);
			header('location:index.php?action=pandOra&target=usersEdit');
		}
		else
		{
			echo 'L\identifiant n\'existe pas';
		}
	}
	else
	{
		echo 'Les données envoyées ne sont pas correctes';
	}
}

function banUser($admin, $userId, $ban)
{
	$adminArray = array('0','1');
	$banArray = array('0','1');
	if(isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin,$adminArray) && isset($ban) && ctype_digit($ban) && in_array($ban,$banArray))
	{
		
		$usersManager = new P4\model\UsersManager();
		if ($users = $usersManager->exists($userId))
		{
			if($ban == 1) // On veut donc autoriser cet utilisateur
			{
				$ban = 0;
				$users = $usersManager->banUser($userId, $ban);
				header('location:index.php?action=pandOra&target=usersEdit');
				
			}
			elseif($ban == 0) // On veut bannir l'utilisateur
			{
				$ban = 1;
				$users = $usersManager->banUser($userId, $ban);
				header('location:index.php?action=pandOra&target=usersEdit');
			}
			
			
		}
		else
		{
			echo 'L\identifiant n\'existe pas';
		}
	}
	else
	{
		echo 'Les données envoyées ne sont pas correctes';
	}
}


?>