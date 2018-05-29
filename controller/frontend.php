<?php
// ---------------------------------------------------------------------- //
// ---------------------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //


// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');
require_once('model/User.php');

// On n'appelle pas la classe model/Manager car elle est déjà appelé dans les deux classes appelées !

// Le controlleur front-end va proposer les différentes fonctions nécessaires pour les vues publiques.

// je dois créer une classe controler et ensuite faire deux objets, une classe FrontControler et une classe BackendControler

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

function newUser($login, $mdp1, $mdp2, $email)
{
	echo 'On est dans la fonction du controleur newUser()<br/><br/>';
	
	$userManager = new P4\model\UsersManager();
	
	$user = new P4\model\User(['login' => $_POST['login'], 'mdp1' => $_POST['mdp1'], 'mdp2' => $_POST['mdp2'], 'email' => $_POST['mail_user'], ]); // On crée un nouvel utilisateur.
	
	$affectedUser = $userManager->addNewUser($user);
	
	if ($affectedUser === false) {
		echo 'on a une erreur';
        throw new Exception('Impossible d\'ajouter le nouvel utilisateur !');
    } else {
		
	}
    
}

?>