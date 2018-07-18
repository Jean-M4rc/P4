<?php
/**
 * Ici c'est notre classe manager de billet,
 * on doit pouvoir récupérer la liste des billets et faire le CRUD des billets
 * 
 */ 

namespace P4\model;

require_once("model/Manager.php");

class PostsManager extends Manager
{
	/**
	 * Fonction qui récupère les récits de l'auteur
	 *
	 * @return $req
	 */
	public function getPosts(){

		$db = $this->dbConnect();		
		$req = $db->query(
			'SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr, resume 
			FROM posts 
			ORDER BY date_create DESC');
		return $req;
	}
	
	/**
	 * Fonction qui récupère un seul récit pour l'afficher en entier
	 *
	 * @param int $postId
	 * @return $post
	 */
	public function getPost($postId){

		$db = $this->dbConnect();		
		$req = $db->prepare(
			'SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr 
			FROM posts 
			WHERE id = ?');		
		$req->execute(array($postId));		
		$post = $req->fetch();
		
		return $post;
	}
	
	/**
	 * Fonction qui ajoute un nouveau récit dans la base de donnée
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $resume
	 * @return void
	 */
	public function addPost($title, $content, $resume){

		$db = $this->dbConnect();		
		$req = $db->prepare('INSERT INTO posts(title, content, resume) VALUES (:title,:content, :resume)');
		$req->execute(array(
			'title' => $title,
			'content' => $content,
			'resume'=>$resume
		));
	}
	
	/**
	 * Fonction qui vérifie l'existance du post
	 *
	 * @param int $id
	 * @return bool
	 */
	public function existsID($id){

		$db = $this->dbConnect();
		$q = $db->prepare('SELECT COUNT(*) FROM posts WHERE ID = :id');
		$q->execute([':id'=>$id]);
		
		return (bool) $q->fetchColumn();
	}
	
	/**
	 * Fonction qui met à jour les informations du récit
	 *
	 * @param int $postID
	 * @param string $postTitle
	 * @param string $postContent
	 * @return $updatedPost
	 */
	public function updatePost($postID, $postTitle, $postContent){

		$db = $this->dbConnect();
		$updatedPost = $db->prepare('UPDATE posts SET title = :title, content = :content  WHERE ID = :postid');
		$updatedPost->execute([
		'title' => $postTitle,
		'content' => $postContent,
		'postid' => $postID
		]);
		
		return $updatedPost;
	}
	
	/**
	 * Fonction qui supprime un récit
	 *
	 * @param int $id
	 * @return void
	 */
	public function deletePost($id){

		$db = $this->dbConnect();
		$req = $db->prepare('DELETE FROM posts WHERE ID= :id');
		$req->execute(array(
			'id' => $id
		));
	}
}
?>