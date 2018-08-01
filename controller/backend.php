<?php

/**
 * Le controleur du Back-End permet de controler les informations sur la gestion du blog
 * la gestion des commentaires, des utilisateurs, des récits.
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com>
 */
// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');

/**
 * fonction adminHome permet d'afficher la page d'accueil de la partie Administration
 *
 * @return void
 */
function adminHome()
{
	require('view/backend/homeAdminView.php');
}

/**
 * 
 *                       POSTS FUNCTIONS
 *  
 */

/**
 * fonction createPostView permet d'afficher la vue pour l'ajout d'un nouveau récit par l'auteur
 * Cette vue contient l'éditeur de texte WYSIWYG TinyMCE
 *
 * @return void
 */
function createPostView()
{
	require('view/backend/createPostView.php');
}

/**
 * Fonction newPost vérifie les données envoyées par l'auteur lors de la création de récit
 * On vérifie le contenu des données envoyées et on crée un résumé du récit pour le conserver
 * dans la BDD
 *
 * @param string $title
 * @param string $post
 * @return void
 */
function newPost($title, $post)
{

	if (isset($post) && is_string($post) && !empty($post) && isset($title) && is_string($title)) {

		$resume = strip_tags(substr($post, 0, 300) . '...', '<br>');
		$postsManager = new P4\model\PostsManager();
		$postsManager->addPost($title, $post, $resume);
		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&log=successPost');

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&log=errorPost');
	}
}

/**
 * Fonction postBackView permet d'afficher dans un tableau l'ensemble des récits contenus dans la BDD
 * Dans ce tableau nous avons la possibilité de modifier ou supprimer ces récits
 *
 * @return void
 */
function postsBackView()
{

	$postsManager = new P4\model\PostsManager();
	$posts = $postsManager->getPosts();
	require('view/backend/postsEditView.php');

}

/**
 * Fonction de modification des récits. Cette fonction permet à l'auteur de corriger ses récits ou de
 * les compléter. Ici aussi nous faisons appelle à l'éditeur TinyMCE pour le texte et la mise en page.
 *
 * @param int $postID
 * @param string $postTitle
 * @param string $postContent
 * 
 * @return void
 */
function updatePost($postID, $postTitle, $postContent)
{

	$postManager = new P4\model\PostsManager;

	if (is_numeric($postID)) {

		if ($postManager->existsID($postID)) {

			if (!empty($postTitle) && strlen($postTitle) > 5 && is_string($postTitle)) {

				if (!empty($postContent) && strlen($postContent) > 20 && is_string($postContent)) {

					$postManager->updatePost($postID, $postTitle, $postContent);
					header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&log=successpostup');

				} else {

					header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&log=errorpostup');
				}

			} else {

				header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&log=errorpostup');
			}

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&log=errorpostup');
		}

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&log=errorpostup');
	}
}

/**
 * Fonction deletePost qui permet à l'administrateur de supprimer un récit
 *
 * @param int $postID
 * @return void
 */
function deletePost($postID)
{

	$postManager = new P4\model\PostsManager;

	if (is_numeric($postID) && $postManager->existsID($postID)) {

		$postManager->deletePost($postID);
		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&postdown=success');

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=postsEdit&postdown=fail');
	}
}

/**
 * 
 *                   COMMENTS FUNCTIONS
 * 
 */

/**
 * Fonction qui permet de lister tout les commentaires présents dans la BDD
 * En même temps une jointure est crée pour récupérer les auteurs des commentaires
 * et les titres des récits commentés
 *
 * @return void
 */
function commentsEdit()
{

	$commentManager = new P4\model\CommentsManager();
	$com = $commentManager->getAllComments();
	require('view/backend/commentsEditView.php');
}

/**
 * Fonction addComment permet à un utilisateur d'envoyer un commentaire sur un récit
 *
 * @param string $comment
 * @param int $postId
 * @param int $autorId
 * 
 * @return void
 */
function addComment($comment, $postId, $autorId)
{

	$comment = nl2br(htmlspecialchars($comment));
	$postManager = new P4\model\PostsManager();

	if ($postManager->existsID($postId)) {

		$userManager = new P4\model\UsersManager();
		if (($userManager->exists($autorId))) {

			$commentManager = new P4\model\CommentsManager();
			$commentManager->addComment($postId, $autorId, $comment);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=post&id=' . $postId . '#comments');

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=post&id=' . $postId . '&src=errorUserId');
			require('view/partial/modalView.php');
		}
	} else {
		header('location:http://jeanforteroche.code-one.fr/index.php?action=post&id=' . $postId . '&src=errorPostId');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction reportComment qui permet de signaler un commentaire
 * Cette fonction est accessible sur la partie publique
 * 
 * @param int $id
 * @param int $postId
 * 
 * @return void
 */
function reportComment($id, $postId)
{

	$commentManager = new P4\model\CommentsManager();

	if ($commentManager->existsID($id)) {

		$commentManager->reportComment($id, 1);
		header('location:http://jeanforteroche.code-one.fr/index.php?action=post&id=' . $postId . '&report=success');

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=post&id=' . $postId . '&report=fail');
	}
}

/**
 * Fonction reportCommentAdmin c'est la gestion du signalement partie Administration
 * Cette fonction permet de signaler mais surtout de lever le signalement par l'administrateur
 *
 * @param int $comment_id
 * @param int $report
 * 
 * @return void
 */
function reportCommentAdmin($comment_id, $report)
{

	$commentManager = new P4\model\CommentsManager();

	if ($commentManager->existsID($comment_id)) {

		if ($report == 1) {

			$report = 0;
			$commentManager->reportComment($comment_id, $report);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit');

		} else if ($report == 0) {

			$report = 1;
			$commentManager->reportComment($comment_id, $report);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit');

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit&src=errorReport');
			require('view/partial/modalView.php');
		}

	} else {
		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit&src=errorComId');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction moderationComment permet de modérer ou d'autoriser un commentaire
 * 
 * @param int $comment_id
 * @param int $moderation
 * 
 * @return void
 */
function moderationComment($comment_id, $moderation)
{

	$commentManager = new P4\model\CommentsManager();

	if ($commentManager->existsID($comment_id)) {

		if ($moderation == 1) {

			$moderation = 0;
			$commentManager->moderateComment($comment_id, $moderation);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit');

		} else if ($moderation == 0) {
			$moderation = 1;
			$commentManager->moderateComment($comment_id, $moderation);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit');

		} else {
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit&src=moderateFail');
			require('view/partial/modalView.php');
		}

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit&src=moderateFail');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction deleteComment permet de supprimer complétement un commentaire
 *
 * @param int $comment_id
 * 
 * @return void
 */
function deleteComment($comment_id)
{

	$commentManager = new P4\model\CommentsManager();

	if ($commentManager->existsID($comment_id)) {

		$commentManager->deletComment($comment_id);
		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit');

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=commentsEdit&src=deleteFail');
		require('view/partial/modalView.php');
	}
}

/**
 * 
 *            USERS FUNCTIONS
 *  
 */

/**
 * Fonction usersEdit qui permet l'affichage de 
 * la liste des utilisateurs du site ainsi que leurs différentes informations 
 *
 * @return void
 */
function usersEdit()
{

	$usersManager = new P4\model\UsersManager();
	$users = $usersManager->listUsersEdit();
	require('view/backend/usersEditView.php');
}

/**
 * Fonction initAvatar qui permet de réinitialiser la photo de profil d'un utilisateur en cas d'abus
 *
 * @param int $userId
 * @return void
 */
function initAvatar($userId)
{

	if (is_numeric($userId)) {

		$usersManager = new P4\model\UsersManager();

		if ($users = $usersManager->exists($userId)) {

			$users = $usersManager->initAvatarPath($userId);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit');

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=initAvatarFail');
			require('view/partial/modalView.php');
		}

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=initAvatarFail');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction qui permet de modifier le rang d'un utilisateur
 *
 * @param int $admin
 * @param int $userId
 * 
 * @return void
 */
function upgradeUser($admin, $userId)
{

	$adminArray = array('0', '1', '2');

	if (isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin, $adminArray)) {

		$usersManager = new P4\model\UsersManager();
		if ($users = $usersManager->exists($userId)) {

			$users = $usersManager->upgradeUser($admin, $userId);
			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit');

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=upgradeFail');
			require('view/partial/modalView.php');
		}

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=upgradeFail');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction banUser qui permet de bannir un membre
 * ce qui l'empêche de se connecter
 *
 * @param int $admin
 * @param int $userId
 * @param int $ban
 * 
 * @return void
 */
function banUser($admin, $userId, $ban)
{
	$adminArray = array('0', '1');
	$banArray = array('0', '1');
	if (isset($userId) && ctype_digit($userId) && isset($admin) && ctype_digit($admin) && in_array($admin, $adminArray) && isset($ban) && ctype_digit($ban) && in_array($ban, $banArray)) {

		$usersManager = new P4\model\UsersManager();
		if ($users = $usersManager->exists($userId)) {

			if ($ban == 1) {

				$ban = 0;
				$users = $usersManager->banUser($userId, $ban);
				header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit');

			} elseif ($ban == 0) {

				$ban = 1;
				$users = $usersManager->banUser($userId, $ban);
				header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit');
			}

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=banFail');
			require('view/partial/modalView.php');
		}

	} else {

		header('location:http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=usersEdit&src=banFail');
		require('view/partial/modalView.php');
	}
}


?>