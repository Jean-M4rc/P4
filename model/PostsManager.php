<?php

namespace P4\model;

/**
 * Classe qui gère le CRUD des récits
 */
class PostsManager extends Manager
{
	/**
	 * Récupère tout les récits de la bdd.
	 *
	 * @return void
	 */
	public function getPosts()
	{

		$db = $this->dbConnect();
		$req = $db->query(
			'SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr, resume 
			FROM posts 
			ORDER BY date_create DESC'
		);
		return $req;
	}
	
	/**
	 * Récupère les données d'un seul récit
	 *
	 * @param int $postId
	 * @return $post
	 */
	public function getPost($postId)
	{

		$db = $this->dbConnect();
		$req = $db->prepare(
			'SELECT ID, title, content, DATE_FORMAT(date_create,\'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr 
			FROM posts 
			WHERE id = ?'
		);
		$req->execute(array($postId));
		$post = $req->fetch();
		return $post;
	}

	/**
	 * Ajout un récit dans la bdd.
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $resume
	 * @return void
	 */
	public function addPost($title, $content, $resume)
	{

		$db = $this->dbConnect();
		$req = $db->prepare(
			'INSERT INTO posts(title, content, resume, date_create) 
			VALUES (:title,:content, :resume, NOW())'
		);
		$req->execute(array(
			'title' => $title,
			'content' => $content,
			'resume' => $resume
		));
	}

	/**
	 * Vérifie l'existence d'un récit par son ID.
	 *
	 * @param int $id
	 * @return void
	 */
	public function existsID($id)
	{

		$db = $this->dbConnect();
		$q = $db->prepare(
			'SELECT COUNT(*) 
			FROM posts 
			WHERE ID = :id'
		);
		$q->execute([':id' => $id]);
		return (bool)$q->fetchColumn();
	}

	/**
	 * Met à jour les valeurs d'un récit.
	 *
	 * @param int $postID
	 * @param string $postTitle
	 * @param string $postContent
	 * @param string $resume
	 * @return void
	 */
	public function updatePost($postID, $postTitle, $postContent, $resume)
	{

		$db = $this->dbConnect();
		$updatedPost = $db->prepare(
			'UPDATE posts 
			SET title = :title, content = :content, resume = :resume  
			WHERE ID = :postid');
		$updatedPost->execute([
			'title' => $postTitle,
			'content' => $postContent,
			'postid' => $postID,
			'resume' => $resume
		]);
		return $updatedPost;
	}

	/**
	 * Supprime l'entrée dans la base de données.
	 *
	 * @param int $id
	 * @return void
	 */
	public function deletePost($id)
	{

		$db = $this->dbConnect();
		$req = $db->prepare(
			'DELETE FROM posts 
			WHERE ID= :id'
		);
		$req->execute(array(
			'id' => $id
		));
	}
}
