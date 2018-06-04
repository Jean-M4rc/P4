<?php

// ---------------------------------------------------------------------- //
// --------- P4 --------------- CONTROLLER ------------------------------ //
// ---------------------------------------------------------------------- //


// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');



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
	// Vérouillage des failles XSS
	$login = htmlspecialchars($_POST['login']);
	$mdp1 = htmlspecialchars($_POST['mdp1']);
	$mdp2 = htmlspecialchars($_POST['mdp2']);
	$email = htmlspecialchars($_POST['mail_user']);

	// On instance un nouveau manager d'utilisateur pour appliquer ses fonctions
	$userManager = new P4\model\UsersManager();
		
	if ($userManager->exists($login))
	{
		// Si cette condition est vraie le pseudo est déjà utilisé
		header('location:index.php?src=signformError&log=loginused');
		require('view/partial/modalView.php');
	}
	else if (strlen($login)<3)
	{
		header('location:index.php?src=signformError&log=loginshort');
		require('view/partial/modalView.php');
	}
	else if ($mdp1 != $mdp2) //Test du mot de passe identiques
	{
		header('location:index.php?src=signformError&log=passwordmirror');
		require('view/partial/modalView.php');
	}
	else if ($userManager->existMail($email)) // Test de l'unicité de l'email
	{
		header('location:index.php?src=signformError&log=mailused');
		require('view/partial/modalView.php');
		
	}
	else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) // Test de la Regex sur l'email
	{
		header('location:index.php?src=signformError&log=mailmirror');
		require('view/partial/modalView.php');
	}
	else //Tout les test sont bons, ont hache le mdp et on insert
	{ 
		$password = password_hash($mdp2, PASSWORD_DEFAULT);
		$affectedUser = $userManager->addNewUser($login, $password, $email);
		$_SESSION['login'] = $login;
		
		header('location:index.php?src=signformSuccess&log=signed');
		require('view/partial/modalView.php');
	}
}


?>