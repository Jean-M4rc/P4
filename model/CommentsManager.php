<?php
/**
 * class CommentManager permet de gérer les commentaires dans la base de donnée
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com> * 
 */
namespace P4\model; // la classe sera dans ce namespace

require_once("model/Manager.php");

class CommentsManager extends Manager
{
	/**
	 * Fonction qui permet de récupérer les commentaires présents dans
	 * la base de donnée pour un récit donné ($postId).
	 * Les commentaires sont rangés par date de rédaction.
	 *
	 * @param int $postId
	 * @return $comments
	 */
	public function getComments($postId){

		$db = $this->dbConnect();
        $comments = $db->prepare('
			SELECT c.id comment_id, c.autor_id, c.comment comment,c.report comment_report,c.moderation comment_moderation,  DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
			u.login user_login, u.avatar_path user_avatar
			FROM comments c
			INNER JOIN users u
			ON c.autor_id = u.ID
			WHERE c.post_id = ? AND c.moderation = 0
			ORDER BY date_comment DESC');
        $comments->execute(array($postId));

        return $comments;
	}
	
	/**
	 * Fonction getAllComments récupère tout les commentaires existant dans la base de donnée.
	 *
	 * @return void
	 */
	public function getAllComments(){

		$db = $this->dbConnect();
        $comments = $db->query(
		'SELECT c.id comment_id, c.autor_id, c.post_id, c.comment comment,c.report comment_report,c.moderation comment_moderation,  DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
		u.login user_login,
		p.title post_title
		FROM comments c
		INNER JOIN users u
		ON c.autor_id = u.ID
		INNER JOIN posts p
		ON c.post_id = p.ID
		ORDER BY moderation, report DESC, date_comment DESC');
        return $comments;
	}
	
	/**
	 * Fonction qui permet de d'ajouter un commentaire dans la bdd
	 *
	 * @param int $postId
	 * @param int $autorId
	 * @param string $comment
	 * @return void
	 */
	public function addComment($postId, $autorId, $comment){

		$db = $this->dbConnect();
		$req = $db->prepare(
			'INSERT INTO comments(post_id, autor_id, comment, date_comment, report, moderation)
			 VALUES (:postId,:autorId,:comment, NOW(), 0 , 0)'
			 );
		$req->execute(array(
			'postId' => $postId,
			'autorId' => $autorId,
			'comment'=>$comment
		));
		
	}
	
	/**
	 * Fonction qui test l'existance d'un commentaire suivant l'id donné
	 *
	 * @param int $id
	 * @return bool
	 */
	public function existsID($id){

		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM comments WHERE ID = :id');
		$q->execute([':id'=>$id]);
		
		return (bool) $q->fetchColumn();
	}
	
	/**
	 * Fonction qui modifie le champ report pour attribuer le statut signalé ou non a un commentaire
	 *
	 * @param int $id
	 * @param int $report
	 * @return $updatedComment
	 */
	public function reportComment($id, $report){

		$db = $this->dbConnect();
		$updatedComment = $db->prepare('UPDATE comments SET report = :report WHERE ID = :commentId');
		$updatedComment->execute([
		'report' => $report,
		'commentId' => $id
		]);
		
		return $updatedComment;
	}
	
	/**
	 * Fonction qui défini la modération d'un commentaire
	 *
	 * @param int $id
	 * @param int $moderation
	 * @return void
	 */
	public function moderateComment($id, $moderation){

		$db = $this->dbConnect();
		$updatedComment = $db->prepare('UPDATE comments SET moderation = :moderation WHERE ID = :commentId');
		$updatedComment->execute([
		'moderation' => $moderation,
		'commentId' => $id
		]);
	}
	
	/**
	 * Fonction qui supprime un commentaire
	 *
	 * @param int $id
	 * @return void
	 */
	public function deletComment($id){
		
		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM comments WHERE ID= :id');
		$req->execute(array(
			'id' => $id
		));
	}
}
?>