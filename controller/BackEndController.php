<?php

namespace P4\controller;

use P4\model\CommentsManager;
use P4\model\PostsManager;
use P4\model\UsersManager;

/**
 * Controle les actions issues de la partie administration
 */
class BackEndController
{

	/**
	 * Affiche la vue d'accueil de l'administration
	 *
	 * @return void
	 */
	public static function adminHome()
	{
		require('view/backend/homeAdminView.php');
	}

	/**
	 * Affiche la vue d'ajout d'un récit
	 *
	 * @return void
	 */
	public static function createPostView()
	{
		require('view/backend/createPostView.php');
	}

	/**
	 * Controle les données envoyées par l'auteur lors de l'ajout d'un récit.
	 * Fabrique un résumé du récit
	 *
	 * @param string $title
	 * @param string $post
	 * @return void
	 */
	public static function newPost($title, $post)
	{
		if (isset($post) && is_string($post) && !empty($post) && isset($title) && is_string($title)) {
			
			$resume = strip_tags(substr($post, 0, 300) . '...', '<br>');
			$postsManager = new PostsManager();
			$postsManager->addPost($title, $post, $resume);
			header('location:' . $GLOBALS['url'] . '?action=pandOra&log=successPost');

		} else {

			header('location:' . $GLOBALS['url'] . '?action=pandOra&log=errorPost');
		}
	}

	/**
	 * Affiche l'ensemble des récits du blog pour les gérer.
	 *
	 * @return void
	 */
	public static function postsBackView()
	{
		$postsManager = new PostsManager();
		$posts = $postsManager->getPosts();
		require('view/backend/postsEditView.php');
	}

	/**
	 * Met à jour un récit.
	 * Vérifie les données envoyés.
	 *
	 * @param int $postID
	 * @param string $postTitle
	 * @param string $postContent
	 * @return void
	 */
	public static function updatePost($postID, $postTitle, $postContent)
	{
		$postManager = new PostsManager;
		
		if (is_numeric($postID)) {

			if ($postManager->existsID($postID)) {

				if (!empty($postTitle) && strlen($postTitle) > 5 && is_string($postTitle)) {

					if (!empty($postContent) && strlen($postContent) > 20 && is_string($postContent)) {

						$postManager->updatePost($postID, $postTitle, $postContent);
						header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&log=successpostup');
					} else {

						header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&log=errorpostup');
					}
				} else {

					header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&log=errorpostup');
				}
			} else {

				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&log=errorpostup');
			}
		} else {

			header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&log=errorpostup');
		}
	}

	/**
	 * Supprime un récit.
	 *
	 * @param int $postID
	 * @return void
	 */
	public static function deletePost($postID)
	{
		$postManager = new PostsManager;
		if (is_numeric($postID) && $postManager->existsID($postID)) {

			$postManager->deletePost($postID);
			header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&postdown=success');

		} else {

			header('location:' . $GLOBALS['url'] . '?action=pandOra&target=postsEdit&postdown=fail');
		}
	}

	/**
	 * Ajoute un commentaire à un récit.
	 *
	 * @param string $comment
	 * @param int $postId
	 * @param int $autorId
	 * @return void
	 */
	public static function addComment($comment, $postId, $autorId) // 2 modal à faire ici ----------------------------------------------------
	{
		$comment = nl2br(htmlspecialchars($comment));
		$postManager = new PostsManager();

		if ($postManager->existsID($postId)) {

			$userManager = new UsersManager();

			if (($userManager->exists($autorId))) {

				$commentManager = new CommentsManager();
				$commentManager->addComment($postId, $autorId, $comment);
				header('location:' . $GLOBALS['url'] . '?action=post&id=' . $postId . '#comments');

			} else {
				echo $postId;
				echo $autorId;
				echo 'Le compte utilisateur est erroné';

			}
		} else {
			echo $postId;
			echo $autorId;
			echo 'Le postId n\'existe pas';
		}
	}

	/**
	 * Signale un commentaire.
	 *
	 * @param int $id
	 * @param int $postId
	 * @return void
	 */
	public static function reportComment($id, $postId) //Peut-être plus cohérent dans le FrontEndController
	{
		$commentManager = new CommentsManager();

		if ($commentManager->existsID($id)) {
			
			$commentManager->reportComment($id, 1);
			header('location:' . $GLOBALS['url'] . '?action=post&id=' . $postId . '&report=success');

		} else {

			header('location:' . $GLOBALS['url'] . '?action=post&id=' . $postId . '&report=fail');
		}
	}

	/**
	 * Permet de lever ou de mettre le signalement d'un commentaire depuis la partie administration.
	 *
	 * @param int $comment_id
	 * @param int $report
	 * @return void
	 */
	public static function reportCommentAdmin($comment_id, $report) // 2 modal à faire ici ------------------------------------------
	{
		$commentManager = new CommentsManager();

		if ($commentManager->existsID($comment_id)) {
			
			if ($report == 1) {
				
				$report = 0;
				$commentManager->reportComment($comment_id, $report);
				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=commentsEdit');

			} else if ($report == 0) {

				$report = 1;
				$commentManager->reportComment($comment_id, $report);
				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=commentsEdit');

			} else {

				echo 'la valeur $report n\'est pas correcte';
			}
		} else {

			echo 'l\'id du com n\'est pas bonne';
		}
	}

	/**
	 * Gère la modération d'un commentaire.
	 *
	 * @param int $comment_id
	 * @param int $moderation
	 * @return void
	 */
	public static function moderationComment($comment_id, $moderation) // 2 modal à faire ici ------------------------------------------
	{
		$commentManager = new CommentsManager();
		if ($commentManager->existsID($comment_id)) {
			
			if ($moderation == 1) {

				$moderation = 0;
				$commentManager->moderateComment($comment_id, $moderation);
				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=commentsEdit');

			} else if ($moderation == 0) {

				$moderation = 1;
				$commentManager->moderateComment($comment_id, $moderation);
				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=commentsEdit');

			} else {

				echo 'la valeur $moderation n\'est pas correcte';
			}
		} else {

			echo 'l\'id du com n\'est pas bonne';
		}
	}

	/**
	 * Supprime un commentaire.
	 *
	 * @param int $comment_id
	 * @return void
	 */
	public static function deleteComment($comment_id)
	{
		$commentManager = new CommentsManager();

		if ($commentManager->existsID($comment_id)) {
			$commentManager->deletComment($comment_id);
			header('location:' . $GLOBALS['url'] . '?action=pandOra&target=commentsEdit');

		} else {

			echo 'l\'id du com n\'est pas bonne';
		}
	}

	/**
	 * Affiche tout les commentaires présents sur le blog.
	 *
	 * @return void
	 */
	public static function commentsEdit()
	{
		$commentManager = new CommentsManager();
		$com = $commentManager->getAllComments();
		require('view/backend/commentsEditView.php');
	}


	/**
	 * Affiche l'ensemble des abonnés pour les gérer.
	 *
	 * @return void
	 */
	public static function usersEdit()
	{
		$usersManager = new UsersManager();
		$users = $usersManager->listUsersEdit();
		require('view/backend/usersEditView.php');
	}

	/**
	 * Permet d'initialiser l'avatar d'un abonné.
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function initAvatar($userId) // 2 modal à faire ici -----------------------------------------
	{
		if (is_numeric($userId)) {

			$usersManager = new UsersManager();

			if ($users = $usersManager->exists($userId)) {

				$users = $usersManager->initAvatarPath($userId);
				header('location:' . $GLOBALS['url'] . '?action=pandOra&target=usersEdit');
				
			} else {

				echo 'l\'id n\'existe pas';
			}
		} else {

			echo 'la valeur envoyé n\'est pas un chiffre';
		}
	}

	/**
	 * Permet de gérer le rang d'un abonné.
	 *
	 * @param int $admin
	 * @param int $userId
	 * @return void
	 */
	public static function upgradeUser($admin, $userId)  // 2 modal à faire ici ------------------------------------------
	{
		$adminArray = array('0', '1', '2');

		if (isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin, $adminArray)) {

			$usersManager = new UsersManager();
			if ($users = $usersManager->exists($userId)) {

				$users = $usersManager->upgradeUser($admin, $userId);
				header('location:' . $GLOBALS['url'] .'?action=pandOra&target=usersEdit');
				
			} else {

				echo 'L\identifiant n\'existe pas';
			}
		} else {

			echo 'Les données envoyées ne sont pas correctes';
		}
	}

	/**
	 * Permet de bannir ou de débannir un abonné.
	 *
	 * @param int $admin
	 * @param int $userId
	 * @param int $ban
	 * @return void
	 */
	public static function banUser($admin, $userId, $ban) // 2 modal à faire ici ------------------------------------------
	{
		$adminArray = array('0', '1');
		$banArray = array('0', '1');

		if (isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin, $adminArray) && isset($ban) && ctype_digit($ban) && in_array($ban, $banArray)) {

			$usersManager = new UsersManager();
			if ($users = $usersManager->exists($userId)) {

				if ($ban == 1) {

					$ban = 0;
					$users = $usersManager->banUser($userId, $ban);
					header('location:' . $GLOBALS['url'] . '?action=pandOra&target=usersEdit');

				} elseif ($ban == 0) {

					$ban = 1;
					$users = $usersManager->banUser($userId, $ban);
					header('location:' . $GLOBALS['url'] . '?action=pandOra&target=usersEdit');
				}
			} else {

				echo 'L\identifiant n\'existe pas';
			}
		} else {

			echo 'Les données envoyées ne sont pas correctes';
		}
	}
}