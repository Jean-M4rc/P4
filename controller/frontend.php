<?php
// ---------------------------------------------------------------------- //
// ---------------------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //
namespace P4\controller;
// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
// On n'appelle pas la classe model/Manager car elle est déjà appelé dans les deux classes appelées !

// Le controlleur front-end va proposer les différentes fonctions nécessaires pour les vues publiques.
// je dois créer une classe controler et ensuite faire deux objets, une classe FrontControler et une classe BackControler
function homePage()
{
	require('view/frontend/homepageView.php');
}
// Première fonction de base listPosts() qui affiche tout les billets de la bdd
function listPosts()
{
	$postsManager = new P4\model\PostsManager(); // Création d'un objet à partir de la classe. Utilisation du namespace
	$posts = $postsManager->getPosts(); // Appel d'une méthode de cette classe pour cet objet.
	
	require('view/frontend/ListPostsView.php'); // Appel de la vue correspondante.
}

?>