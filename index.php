<?php
// ------------------------------------------------------------------ //
// ------------------------ INDEX.PHP ------------------------------- //
// --------------------- LE ROUTEUR DU SITE ------------------------- //
// ------------------------------------------------------------------ //

// Ici c'est le routeur, comme adresse de base je veux afficher une page d'accueil graphique épurée très nature
echo "Ca vient !!!";

require('controller\frontend.php');
require('controller\backend.php');

try {
	if(isset($_GET['action'])){
		echo "Il y a une action $_GET qu'elle est l'action à mener ?";
	} 
	else 
	{
		listPosts(); // Ici c'est la page par défaut du site, à l'avenir il faudra la changer avec une page d'accueil et non une page de lecture.
	}
	
}
catch(Exception $e){
	echo 'Erreur :' . $e->getMessage();
}
?>