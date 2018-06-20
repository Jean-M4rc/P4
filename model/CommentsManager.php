<?php

namespace P4\model; // la classe sera dans ce namespace


require_once("model/Manager.php");

class CommentsManager extends Manager
{
	public function getComments($postId)
	{
		$db = $this->dbConnect();
		
		$req = $db->prepare('SELECT ID, comment, autor_id, DATE_FORMAT(date_comment,\'%d/%m/%Y à %Hh%imin%ss\') AS date_comment_fr, report, moderation FROM comments WHERE post_id= ? ORDER BY date_comment DESC');
		
		$comments = $req->execute(array($postId));
		
		return $comments;
	}
}
?>