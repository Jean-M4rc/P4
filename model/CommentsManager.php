<?php

<<<<<<< HEAD
/**
 * class CommentManager permet de gérer les commentaires dans la base de donnée
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com> * 
 */
namespace P4\model; // la classe sera dans ce namespace

require_once("model/Manager.php");
=======
namespace P4\model;
>>>>>>> poo_transform

/**
 * Classe qui gère le CRUD des commentaires.
 */
class CommentsManager extends Manager
{
	/**
<<<<<<< HEAD
	 * Fonction qui permet de récupérer les commentaires présents dans
	 * la base de donnée pour un récit donné ($postId).
	 * Les commentaires sont rangés par date de rédaction.
=======
	 * Permet de sélectionner les commentaires d'un post.
>>>>>>> poo_transform
	 *
	 * @param int $postId
	 * @return $comments
	 */
	public function getComments($postId)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$comments = $db->prepare('
			SELECT c.id comment_id, c.autor_id, c.comment comment,c.report comment_report,c.moderation comment_moderation,  DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
			u.login user_login, u.avatar_path user_avatar
			FROM comments c
			INNER JOIN users u
			ON c.autor_id = u.ID
			WHERE c.post_id = ? AND c.moderation = 0
			ORDER BY date_comment DESC');
		$comments->execute(array($postId));
=======
        $comments = $db->prepare(
			'SELECT c.id comment_id, c.autor_id, c.comment comment,c.report comment_report,c.moderation comment_moderation, DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
			u.login user_login, u.avatar_path user_avatar
			FROM comments c
				INNER JOIN users u
				ON c.autor_id = u.ID
			WHERE c.post_id = ? AND c.moderation = 0
			ORDER BY date_comment DESC');
        $comments->execute(array($postId));
>>>>>>> poo_transform

		return $comments;
	}
<<<<<<< HEAD

	/**
	 * Fonction getAllComments récupère tout les commentaires existant dans la base de donnée.
	 *
	 * @return void
=======
	
	/**
	 * Permet de récupérer tout les commentaires présents dans la base de données
	 *
	 * @return $comments
>>>>>>> poo_transform
	 */
	public function getAllComments()
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$comments = $db->query(
			'SELECT c.id comment_id, c.autor_id, c.post_id, c.comment comment,c.report comment_report,c.moderation comment_moderation,  DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
=======
        $comments = $db->query(
		'SELECT c.id comment_id, c.autor_id, c.post_id, c.comment comment,c.report comment_report,c.moderation comment_moderation,  DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
>>>>>>> poo_transform
		u.login user_login,
		p.title post_title
		FROM comments c
		INNER JOIN users u
		ON c.autor_id = u.ID
		INNER JOIN posts p
		ON c.post_id = p.ID
		ORDER BY moderation, report DESC, date_comment DESC'
		);
		return $comments;
	}
<<<<<<< HEAD

	/**
	 * Fonction qui permet de d'ajouter un commentaire dans la bdd
=======
	
	/**
	 * Ajoute un commentaire à un récit
>>>>>>> poo_transform
	 *
	 * @param int $postId
	 * @param int $autorId
	 * @param string $comment
	 * @return void
	 */
	public function addComment($postId, $autorId, $comment)
	{

		$db = $this->dbConnect();
		$req = $db->prepare(
<<<<<<< HEAD
			'INSERT INTO comments(post_id, autor_id, comment, date_comment, report, moderation)
			 VALUES (:postId,:autorId,:comment, NOW(), 0 , 0)'
		);
=======
			'INSERT INTO comments(post_id, autor_id, comment, date_comment, report, moderation) 
			VALUES (:postId,:autorId,:comment, NOW(), 0 , 0)'
		);

>>>>>>> poo_transform
		$req->execute(array(
			'postId' => $postId,
			'autorId' => $autorId,
			'comment' => $comment
		));
<<<<<<< HEAD

	}

	/**
	 * Fonction qui test l'existance d'un commentaire suivant l'id donné
=======
	}
	
	/**
	 * Permet de vérifier l'existaence d'un commentaire par son ID.
>>>>>>> poo_transform
	 *
	 * @param int $id
	 * @return bool
	 */
	public function existsID($id)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$q = $db->prepare('SELECT COUNT(*) FROM comments WHERE ID = :id');
		$q->execute([':id' => $id]);

		return (bool)$q->fetchColumn();
	}

	/**
	 * Fonction qui modifie le champ report pour attribuer le statut signalé ou non a un commentaire
=======
		$q = $db->prepare(
			'SELECT COUNT(*) 
			FROM comments 
			WHERE ID = :id'
		);
		$q->execute([':id'=>$id]);
		
		return (bool) $q->fetchColumn();
	}
	
	/**
	 * Permet de modifier la valeur report (signalement) d'un commentaire.)
>>>>>>> poo_transform
	 *
	 * @param int $id
	 * @param int $report
	 * @return $updatedComment
	 */
	public function reportComment($id, $report)
	{

		$db = $this->dbConnect();
		$updatedComment = $db->prepare(
			'UPDATE comments 
			SET report = :report 
			WHERE ID = :commentId'
		);
		$updatedComment->execute([
			'report' => $report,
			'commentId' => $id
		]);
<<<<<<< HEAD

		return $updatedComment;
	}

	/**
	 * Fonction qui défini la modération d'un commentaire
=======
		return $updatedComment;
	}
	
	/**
	 * Permet de modifier la valeur de modération d'un commentaire 
>>>>>>> poo_transform
	 *
	 * @param int $id
	 * @param int $moderation
	 * @return void
	 */
	public function moderateComment($id, $moderation)
	{

		$db = $this->dbConnect();
		$updatedComment = $db->prepare(
			'UPDATE comments 
			SET moderation = :moderation 
			WHERE ID = :commentId'
		);
		$updatedComment->execute([
			'moderation' => $moderation,
			'commentId' => $id
		]);
	}
<<<<<<< HEAD

	/**
	 * Fonction qui supprime un commentaire
=======
	
	/**
	 * Permet de supprimer un commentaire.
>>>>>>> poo_transform
	 *
	 * @param int $id
	 * @return void
	 */
	public function deletComment($id)
	{

		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM comments WHERE ID= :id');
		$req->execute(array(
			'id' => $id
		));
	}
}