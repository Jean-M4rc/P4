<?php

namespace P4\controller;

use P4\model\CommentsManager;
use P4\model\PostsManager;
use P4\model\UsersManager;

class BackEndController{
	
	public static function adminHome(){
		require('view/backend/homeAdminView.php');
	}

	public static function createPostView(){
		require('view/backend/createPostView.php');
	}

	public static function newPost($title,$post){
		if (isset($post) && is_string($post) && !empty($post) && isset($title) && is_string($title))
		{
			// On crée un résumé du récit
			$resume = strip_tags(substr($post,0,300) . '...','<br>');
			// On peut appeler le model et la vue pour sauvegarder ce nouveau récit
			$postsManager = new PostsManager();
			$postsManager->addPost($title, $post, $resume);
			header('location:index.php?action=pandOra&log=successPost');
		}
		else
		{
			header('location:index.php?action=pandOra&log=errorPost');
		}
	}

	public static function postsBackView(){
		$postsManager = new PostsManager();
		$posts = $postsManager->getPosts();
		require('view/backend/postsEditView.php');
		
	}

	public static function updatePost($postID, $postTitle, $postContent){
		// On controle les valeurs et on update
		$postManager = new PostsManager;
		
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

	public static function deletePost($postID){
		$postManager = new PostsManager;
		
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

	public static function addComment($comment,$postId,$autorId){
		//Test des valeurs $comment, de l'existence de postid et de autorId
		$comment = nl2br(htmlspecialchars($comment));
		
		$postManager = new PostsManager();
		if ($postManager->existsID($postId))
		{
			$userManager = new UsersManager();
			if (($userManager->exists($autorId)))
			{
				$commentManager = new CommentsManager();
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

	public static function reportComment($id, $postId){
		// test de l'existence du com
		$commentManager = new CommentsManager();
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

	public static function reportCommentAdmin($comment_id,$report){
		// test de l'existence du com
		$commentManager = new CommentsManager();
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

	public static function moderationComment($comment_id, $moderation){
		// test de l'existence du com
		$commentManager = new CommentsManager();
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

	public static function deleteComment($comment_id){
		
		$commentManager = new CommentsManager();
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

	public static function commentsEdit(){
		$commentManager = new CommentsManager();
		$com = $commentManager->getAllComments(); 
		require('view/backend/commentsEditView.php');	
	}

	public static function usersEdit(){
		$usersManager = new UsersManager();
		$users = $usersManager->listUsersEdit();
		require('view/backend/usersEditView.php');
	}

	public static function initAvatar($userId){
		if(is_numeric($userId))
		{
			$usersManager = new UsersManager();
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

	public static function upgradeUser($admin,$userId){
		$adminArray = array('0','1','2');
		if(isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin,$adminArray))
		{
			
			$usersManager = new UsersManager();
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

	public static function banUser($admin, $userId, $ban){
		$adminArray = array('0','1');
		$banArray = array('0','1');
		if(isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin,$adminArray) && isset($ban) && ctype_digit($ban) && in_array($ban,$banArray))
		{
			
			$usersManager = new UsersManager();
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
}