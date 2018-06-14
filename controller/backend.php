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
		header('location:index.php?action=pandOra&successpost');
		
	}
	else
	{
		echo 'le contenu est vide';
		// header('location:index.php?action=pandOra&errorpost');
		// Avec la modal qui va avec
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
					header('location:index.php?action=pandOra&target=postsEdit&successpostup');					
				}
				else
				{
					// header('location:index.php?action=pandOra&errorpostup');
					// Avec la modal qui va avec
					echo "le contenu du récit n'est pas valide";
				}
			}
			else
			{
				// header('location:index.php?action=pandOra&errorpostup');
				// Avec la modal qui va avec
				echo "le titre du récit n'est pas valide";
			}
		}
		else
		{
			// header('location:index.php?action=pandOra&errorpostup');
			// Avec la modal qui va avec
			echo "l'ID du récit n'existe pas";
		}
	}
	else
	{
		// header('location:index.php?action=pandOra&errorpostup');
		// Avec la modal qui va avec
		echo "l'ID du récit n'est pas valide";
	}
	
	
	
	
}
?>