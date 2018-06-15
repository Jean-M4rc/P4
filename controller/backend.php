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
		$resume = substr($post,0,300). '...';
		$resumeEnd = strip_tags($resume,'<br>');
		// On peut appeler le model et la vue pour sauvegarder ce nouveau récit
		$postsManager = new P4\model\PostsManager();
		$postsManager->addPost($title, $post, $resumeEnd);
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

function deletePost($postID)
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
?>