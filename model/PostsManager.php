<?php
// Ici c'est notre classe manager de billet, on doit pouvoir récupérer la liste des billets et faire le CRUD des billets

namespace P4\model; // la classe sera dans ce namespace


require_once("model/Manager.php");

class PostsManager extends Manager
{
	
	public function getPosts()
	{
		$db = $this->dbConnect();
		
		$req = $db->query('SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr, resume FROM posts ORDER BY date_create DESC');
		
		return $req;
	}
	
	// Ici on récupère un seul billet en fonction de son id passé en paramètre
	public function getPost($postId) 
	{
		$db = $this->dbConnect();
		
		$req = $db->prepare('SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr FROM posts WHERE id = ?');
		
		$req->execute(array($postId));
		
		$post = $req->fetch();
		
		return $post;
	}
	
	public function addPost($title, $content, $resume)
	{
		$db = $this->dbConnect();
		
		$req = $db->prepare('INSERT INTO posts(title, content, resume) VALUES (:title,:content, :resume)');
		$req->execute(array(
			'title' => $title,
			'content' => $content,
			'resume'=>$resume
		));
		
	}
}
?>