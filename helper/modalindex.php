<?php
/**
 * Routeur des modals d'informations (helper)
*/

if (isset($_GET['src'])) {

	if ($_GET['src'] == "signformError") {

		switch ($_GET['log']) {

			case 'loginused':
				$contentModal = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
				$targetModal = "#signInModal";
				break;

			case 'loginshort':
				$contentModal = "Ce pseudo est trop court, veuillez en choisir un autre.";
				$targetModal = "#signInModal";
				break;

			case 'passwordshort':
				$contentModal = "Votre mot de passe est trop court, veuillez en choisir un autre.";
				$targetModal = "#signInModal";
				break;

			case 'passwordmirror':
				$contentModal = 'Les mots de passe ne sont pas identiques';
				$targetModal = "#signInModal";
				break;

			case 'mailused':
				$contentModal = 'Cette adresse email est déjà utilisée. Veuillez en renseigner une autre.';
				$targetModal = "#signInModal";
				break;

			case 'mailmirror':
				$contentModal = 'L\'adresse email n\'est pas valide.';
				$targetModal = "#signInModal";
				break;
		}
		require 'view/partial/targetFailModal.php';

	} else if ($_GET['src'] == 'logInError') {

		$contentModal = "Votre identifiant ou votre mot de passe est erroné.";
		$targetModal = "#logInModal";
		require 'view/partial/targetFailModal.php';

	} else if ($_GET['src'] == 'success') {

		switch ($_GET['log']) {

			case ('signed'):
				$titleModal = 'Félicitations';
				$contentModal = '<h5 class="font-weight-bold">Bienvenue ' . $_SESSION['login'] . ' !</h5><br/><p><span class="text-success font-weight-bold">Vous êtes désormais inscrit sur notre blog et connecté.</span></p>';
				break;

			case ('logged'):
				$titleModal = 'Félicitations';
				$contentModal = '<h5 class="font-weight-bold">Bonjour ' . $_SESSION['login'] . ' !</h5><br/><p><span class="text-success font-weight-bold">Vous êtes désormais connecté.</span><br/></p><p class="text-dark">Vous pouvez vous déconnecter en cliquant sur le bouton "Déconnexion" dans le menu de navigation.</p>';
				break;
		}
		require 'view/partial/successModal.php';

	} else if ($_GET['src'] == 'userBanned') {

		$contentModal = "Vous n'êtes plus autorisé à vous connecter sur ce site, vous êtes banni.";
		require 'view/partial/failModal.php';
	}
} else if (isset($_GET['Exception'])) {

	require 'view/partial/failModal.php';

} else if (isset($_GET['action']) && $_GET['action'] == 'userProfil') {

	if (isset($_GET['error'])) {

		switch ($_GET['error']) {
			case 'loginused':
				$contentModal = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";

				break;

			case 'loginshort':
				$contentModal = "Ce pseudo est trop court, veuillez en choisir un autre.";
				break;

			case 'passwordshort':
				$contentModal = "Votre mot de passe est trop court, veuillez en choisir un autre.";
				break;

			case 'passwordwrong':
				$contentModal = "Votre mot de passe est erroné";
				break;

			case 'passwordmirror':
				$contentModal = 'Les mots de passe ne sont pas identiques';
				break;

			case 'mailused':
				$contentModal = 'Cette adresse email est déjà utilisée. Veuillez en renseigner une autre.';
				break;

			case 'mailmirror':
				$contentModal = 'L\'adresse email n\'est pas valide.';
				break;

			case 'imagewrong':
				$contentModal = 'L\'image n\'est pas valide.';
				break;

			case 'imagesize':
				$contentModal = 'L\'image dépasse les 2Mo.';
				break;

			case 'uploaderror':
				$contentModal = 'Le téléchargement a échoué.';
				break;
		}
		require 'view/partial/failModal.php';

	} else if (isset($_GET['log']) && $_GET['log'] == 'signOutError') {

		$contentModal = "Le mot de passe n'est pas valide.";
        $targetModal = "#signOutModal";
        require 'view/partial/targetFailModal.php';

	} else if (isset($_GET['success']) && $_GET['success'] == 'true') {
		
        $contentModal = "Votre profil a été mis à jour.";
        require 'view/partial/successModal.php';

	}
} else if (isset($_GET['action']) && $_GET['action'] == 'pandOra') {

	if (isset($_GET['target']) && $_GET['target'] == 'postsEdit') {

		if (isset($_GET['log'])) {

			switch ($_GET['log']) {

				case 'successpostup':
                    $contentModal = "Votre récit a bien été mis à jour";
                    require 'view/partial/successModal.php';
					break;

				case 'errorpostup':
                    $contentModal = "Une erreur est survenue. Votre récit n'a pas été mis à jour";
                    require 'view/partial/failModal.php';
					break;
			}
		} else if (isset($_GET['postdown'])) {

			switch ($_GET['postdown']) {

				case 'success':
                    $contentModal = "Votre récit a bien été supprimé.";
                    require 'view/partial/successModal.php';
					break;

				case 'fail':
                    $contentModal = "Une erreur est survenue. Votre récit n'a pas été supprimé.";
                    require 'view/partial/failModal.php';
					break;
			}
		}
	} else if (isset($_GET['log'])) {

		switch ($_GET['log']) {

			case 'successPost':
                $contentModal = "Votre récit est bien ajouté";
                require 'view/partial/successModal.php';
				break;

			case 'errorPost':
                $contentModal = "Une erreur est survenue. Votre récit n'est pas ajouté. Veuillez bien remplir les champs.";
                require 'view/partial/failModal.php';
				break;
		}
	}
}
