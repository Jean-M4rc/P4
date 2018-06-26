<?php

// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');


function adminHome()
{
	require('view/backend/homeAdminView.php');
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
			header('location:index.php?action=post&id=' . $postId .'&log=addcommentsuccess');
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
?>