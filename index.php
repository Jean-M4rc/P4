<?php

// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// --------------------- LE ROUTEUR DU SITE ------------------------- //
// ------------------------------------------------------------------ //

// On appelle session_start() APRES avoir enregistré l'autoload.
session_start();
// Ici c'est le routeur, comme adresse de base 
// je veux afficher une page d'accueil graphique épurée très nature

// Auto-loader -------------------------

require('controller/frontend.php');
require('controller/backend.php');

// Routeur --------------

try {
	
	// D'abord on écoute la déconnexion
	if (isset($_GET['deconnexion']))
	{
	session_destroy();
	header('Location: .');
	exit();
	}
	
	if(isset($_GET['action']))
	{
		if($_GET['action']== 'listPosts')
		{
			listPosts();
		}
		else if($_GET['action']== 'signin') //inscription au blog
		{
			// Les valeurs envoyer par le formulaire sont 
			// login mdp1 mdp2 mail_user
			// La l'utilisateur a passer la vérification js du formulaire d'inscription
			// On doit lancer la fonction du controleur qui va vérifier les données des $_POST
			// et les sécuriser !
			// ensuite on appelle le model et on crée l'utilisateur
			
			if (!empty($_POST['login']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2']) && !empty($_POST['mail_user']))
			{
				// On appelle la méthode newUser du controler pour vérifier appeler le model et vérifier les données
				newUser($_POST['login'], $_POST['mdp1'], $_POST['mdp2'], $_POST['mail_user']);
			}
			else
			{
				throw new Exception('Tous les champs ne sont pas remplis ! newUser()');
			}	
			/*
			if (isset ($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
			{
				$perso = new Personnage(['nom' => $_POST['nom']]); // On crée un nouveau personnage.
	
				if (!$perso->nomValide())
				{
					$message = 'Le nom choisi est invalide.';
					unset($perso);
				}
				elseif ($manager->exists($perso->nom()))
				{
					$message = 'Le nom choisi est déjà pris.';
					unset($perso);
				}
				else
				{
					$manager->AddNewPersonnage($perso);
				}
			}		
			*/
		}
		else if($_GET['action']== 'signed')
		{
			homepage();
		}
		else {
			throw new Exception('Votre inscription est en cours');
		}
	} 
	else 
	{
		homePage();
	}
	
}
catch(Exception $e){
	$msgError = $e->getMessage();
	require('view/frontend/errorView.php');
}
?> 