<?php

namespace P4\model; // la classe sera dans ce namespace

require_once("model/Manager.php");

class CommentsManager extends Manager
{
	public function getComments($postId)
	{
		$db = $this->dbConnect();
        $comments = $db->prepare('
		SELECT c.id comment_id, c.autor_id, c.comment comment, DATE_FORMAT(date_comment, \'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr,
		u.login user_login, u.avatar_path user_avatar
		FROM comments c
		INNER JOIN users u
		ON c.autor_id = u.ID
		WHERE c.post_id = ?
		ORDER BY date_comment DESC');
        $comments->execute(array($postId));

        return $comments;
	}
	
	public function addComment($postId, $autorId, $comment)
	{
		$db = $this->dbConnect();
		
		$req = $db->prepare('INSERT INTO comments(post_id, autor_id, comment, date_comment, report, moderation) VALUES (:postId,:autorId,:comment, NOW(), 0 , 0)');
		$req->execute(array(
			'postId' => $postId,
			'autorId' => $autorId,
			'comment'=>$comment
		));
		
	}
}
?>