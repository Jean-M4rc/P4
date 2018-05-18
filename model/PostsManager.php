<?php
// Ici c'est notre classe manager de billet, on doit fpouvoir récupérer la liste des billets et faire le CRUD des billets
namespace Jim\P4\model; // la classe sera dans ce namespace

require_once("model/Manager.php");

class PostsManager extends Manager
{
	 //Ici on écrit la méthode qui récupère tous les billets de la bdd
	public function getPosts()
	{
		$db = $this->dbConnect();
		
		$req = $db->query('SELECT id, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr, DATE_FORMAT(date_update,\'%d/%m/%Y à %Hh%imin%ss\') AS date_update_fr FORM posts ORDER BY date_create');
		
		return $req;
	}
	
	// Ici on récupère un seul billet en fonction de son id passé en paramètre
	public function getPost($postId) 
	{
		$db = $this->dbConnect();
		
		$req = $db->prepare('SELECT id, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr, DATE_FORMAT(date_update,\'%d/%m/%Y à %Hh%imin%ss\') AS date_update_fr FORM posts WHERE id = ?');
		
		$req->execute(array($postId));
		
		$post = $req->fetch();
		
		return $post;
	}
}
?>