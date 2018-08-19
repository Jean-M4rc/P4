<?php

<<<<<<< HEAD
/**
 * Ici c'est notre classe manager de billet,
 * on doit pouvoir récupérer la liste des billets et faire le CRUD des billets
 * 
 */

namespace P4\model;

require_once("model/Manager.php");
=======
namespace P4\model;
>>>>>>> poo_transform

/**
 * Classe qui gère le CRUD des récits
 */
class PostsManager extends Manager
{
	/**
<<<<<<< HEAD
	 * Fonction qui récupère les récits de l'auteur
	 *
	 * @return $req
=======
	 * Récupère tout les récits de la bdd.
	 *
	 * @return void
>>>>>>> poo_transform
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
<<<<<<< HEAD

	/**
	 * Fonction qui récupère un seul récit pour l'afficher en entier
=======
	
	/**
	 * Récupère les données d'un seul récit
>>>>>>> poo_transform
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
<<<<<<< HEAD

=======
>>>>>>> poo_transform
		return $post;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui ajoute un nouveau récit dans la base de donnée
=======
	 * Ajout un récit dans la bdd.
>>>>>>> poo_transform
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $resume
	 * @return void
	 */
	public function addPost($title, $content, $resume)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$req = $db->prepare('INSERT INTO posts(title, content, resume) VALUES (:title,:content, :resume)');
=======
		$req = $db->prepare(
			'INSERT INTO posts(title, content, resume, date_create) 
			VALUES (:title,:content, :resume, NOW())'
		);
>>>>>>> poo_transform
		$req->execute(array(
			'title' => $title,
			'content' => $content,
			'resume' => $resume
		));
	}

	/**
<<<<<<< HEAD
	 * Fonction qui vérifie l'existance du post
	 *
	 * @param int $id
	 * @return bool
=======
	 * Vérifie l'existence d'un récit par son ID.
	 *
	 * @param int $id
	 * @return void
>>>>>>> poo_transform
	 */
	public function existsID($id)
	{

		$db = $this->dbConnect();
<<<<<<< HEAD
		$q = $db->prepare('SELECT COUNT(*) FROM posts WHERE ID = :id');
		$q->execute([':id' => $id]);

=======
		$q = $db->prepare(
			'SELECT COUNT(*) 
			FROM posts 
			WHERE ID = :id'
		);
		$q->execute([':id' => $id]);
>>>>>>> poo_transform
		return (bool)$q->fetchColumn();
	}

	/**
<<<<<<< HEAD
	 * Fonction qui met à jour les informations du récit
=======
	 * Met à jour les valeurs d'un récit.
>>>>>>> poo_transform
	 *
	 * @param int $postID
	 * @param string $postTitle
	 * @param string $postContent
<<<<<<< HEAD
	 * @return $updatedPost
	 */
	public function updatePost($postID, $postTitle, $postContent)
=======
	 * @param string $resume
	 * @return void
	 */
	public function updatePost($postID, $postTitle, $postContent, $resume)
>>>>>>> poo_transform
	{

		$db = $this->dbConnect();
		$updatedPost = $db->prepare(
			'UPDATE posts 
			SET title = :title, content = :content, resume = :resume  
			WHERE ID = :postid');
		$updatedPost->execute([
			'title' => $postTitle,
			'content' => $postContent,
<<<<<<< HEAD
			'postid' => $postID
		]);

=======
			'postid' => $postID,
			'resume' => $resume
		]);
>>>>>>> poo_transform
		return $updatedPost;
	}

	/**
<<<<<<< HEAD
	 * Fonction qui supprime un récit
=======
	 * Supprime l'entrée dans la base de données.
>>>>>>> poo_transform
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
