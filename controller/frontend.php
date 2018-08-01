<?php

/**
 * Controlleur Front-End
 * 
 * Permet de controler les différentes entrées saisies par l'utilisateur sur la partie "public" du blog.
 * Renvoi demande ensuite aux différents managers les actions requises et appelle la vue correspodante.
 * 
 * @author Jean-Marc Voisin <jeanmarc.voisin.tai@gmail.com>
 */

// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');

/**
 * Fonction homepage() sert à afficher la page d'accueil du blog.
 * Elle est appelée par défaut.
 *
 * @return homepageView;
 */
function homePage()
{
	require('view/frontend/homepageView.php');
}

/**
 * Fonction listPosts() sert à afficher la liste des récits sur la page 
 * Elle est appelée quand on clique sur le lien "Mes aventures"
 * 
 * @return ListPostView;
 */
function listPosts()
{
	$postsManager = new P4\model\PostsManager();
	$posts = $postsManager->getPosts();
	require('view/frontend/ListPostsView.php');
}

/**
 * Fonction post($id) permet d'afficher un récit en entier
 * Elle est appelée quand on clique sur "En savoir plus" sur un récit dans la vue listPost
 *
 * @param int $id
 * @return postView;
 */
function post($id)
{
	$postsManager = new P4\model\PostsManager();
	if ($postsManager->existsID($id)) {
		$post = $postsManager->getPost($id);
		$commentsManager = new P4\model\CommentsManager();
		$comments = $commentsManager->getComments($id);
		require('view/frontend/postView.php');
	} else {
		header('location:http://jeanforteroche.code-one.fr/index.php?src=errorPostId');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction de création d'utilisateur
 * Cette fonction reçoit les informations du formuliare d'inscription
 * Elle controle la qualité et la sécurité des données reçues
 * Et elle valide l'inscription selon plusieurs critères
 * Une fois l'inscription validé la fonction lance la session pour 
 * permettre à l'utilisateur d'avoir accès au contenu réservé
 *
 * @param string $login
 * @param string $mdp1
 * @param string $mdp2
 * @param string $email
 * @return void
 */
function newUser($login, $mdp1, $mdp2, $email)
{

	$login = htmlspecialchars($_POST['login']);
	$mdp1 = htmlspecialchars($_POST['mdp1']);
	$mdp2 = htmlspecialchars($_POST['mdp2']);
	$email = htmlspecialchars($_POST['mail_user']);

	$userManager = new P4\model\UsersManager();
	$adress = $_SERVER['HTTP_REFERER'];

	if (($adress == 'http://jeanforteroche.code-one.fr/index.php') || $adress == 'http://jeanforteroche.code-one.fr/') {

		$adress = 'http://jeanforteroche.code-one.fr/index.php?';

	} else {

		$adress = $_SERVER['HTTP_REFERER'] . '&';
	}

	if ($userManager->exists($login)) {

		header('location:' . $adress . 'src=signformError&log=loginused');
		require('view/partial/modalView.php');

	} else if (strlen($login) < 3) {

		header('location:' . $adress . 'src=signformError&log=loginshort');
		require('view/partial/modalView.php');

	} else if ($mdp1 != $mdp2) {

		header('location:' . $adress . 'src=signformError&log=passwordmirror');
		require('view/partial/modalView.php');

	} else if (strlen($mdp2) <= 5) {

		header('location:' . $adress . 'src=signformError&log=passwordshort');
		require('view/partial/modalView.php');

	} else if ($userManager->existMail($email)) {

		header('location:' . $adress . 'src=signformError&log=mailused');
		require('view/partial/modalView.php');

	} else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {

		header('location:' . $adress . 'src=signformError&log=mailmirror');
		require('view/partial/modalView.php');

	} else {

		$password = password_hash($mdp2, PASSWORD_DEFAULT);
		$affectedUser = $userManager->addNewUser($login, $password, $email);
		$_SESSION['login'] = $login;
		sessionUser($_SESSION['login']);
		header('location:' . $adress . 'src=signformSuccess&log=signed');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction logUser permet de se connecter au blog, cette fonction permet de
 * reconnaitre les droits de l'utilisateur et d'utiliser un cookie de connexion
 *
 * @param string $login
 * @param string $password
 * @param int $cookied
 * 
 * @return user_logged;
 */
function logUser($login, $password, $cookied)
{

	$login = htmlspecialchars($_POST['pseudo']);
	$password = htmlspecialchars($_POST['mdp']);

	$userManager = new P4\model\UsersManager();

	$adress = $_SERVER['HTTP_REFERER'];

	if (($adress === 'http://jeanforteroche.code-one.fr/index.php') || $adress === 'http://jeanforteroche.code-one.fr/') {
		$adress = 'http://jeanforteroche.code-one.fr/index.php?';
	} else {
		$adress = $_SERVER['HTTP_REFERER'] . '&';
	}

	if ($userManager->exists($login)) {

		$infoUser = $userManager->userInfos($login);

		$isPasswordCorrect = password_verify($password, $infoUser['password']);

		if ($isPasswordCorrect) {

			if ($infoUser['ban'] == 1) {

				header('location:' . $adress . 'src=userBanned');
				require('view/partial/modalView.php');

			} else {

				$_SESSION['userId'] = $infoUser['ID'];
				$_SESSION['login'] = $infoUser['login'];
				$_SESSION['password'] = $infoUser['password'];
				$_SESSION['date_sign'] = $infoUser['date_sign'];
				$_SESSION['email'] = $infoUser['email'];
				$_SESSION['rule'] = $infoUser['admin'];
				$_SESSION['country'] = $infoUser['country'];
				$_SESSION['avatar_path'] = $infoUser['avatar_path'];

				if ($cookied == 1) {

					setcookie('login', $infoUser['login'], time() + 365 * 24 * 3600, null, null, false, true);
					setcookie('password', $infoUser['password'], time() + 365 * 24 * 3600, null, null, false, true);

				} else if ($cookied == 0) {

					setcookie('login', '');
					setcookie('password', '');
				}

				header('location:' . $adress . 'src=success&log=logged');
				require('view/partial/modalView.php');
			}

		} else {

			header('location:' . $adress . 'src=logInError');
			require('view/partial/modalView.php');
		}

	} else {

		header('location:' . $adress . 'src=logInError');
		require('view/partial/modalView.php');
	}
}

/**
 * Fonction qui permet d'afficher la vue de
 * personnalisation du profil de l'utilisateur
 *
 * @return void
 */
function userProfil()
{

	require('view/frontend/userProfilView.php');
}

/**
 * Fonction qui défini les données de l'utilisateur en $_SESSION
 * à partir de son $login. Cela permet de garder des informations
 * de personnalisation facilement accessibles.
 *
 * @param string $login
 * 
 * @return void
 */
function sessionUser($login)
{

	$userManager = new P4\model\UsersManager();
	$infoUser = $userManager->userInfos($login);

	$_SESSION['userId'] = $infoUser['ID'];
	$_SESSION['login'] = $infoUser['login'];
	$_SESSION['password'] = $infoUser['password'];
	$_SESSION['date_sign'] = $infoUser['date_sign'];
	$_SESSION['email'] = $infoUser['email'];
	$_SESSION['rule'] = $infoUser['admin'];
	$_SESSION['country'] = $infoUser['country'];
	$_SESSION['avatar_path'] = $infoUser['avatar_path'];
}

/**
 * Fonction de mise à jour des infos de l'utilisateur.
 * Dans la vue de personnalisation l'utilisateur peut remplir un formulaire
 * pour modifier ses informations. Ici nous controlons la validié de ses nouvelles informations.
 * Aussi nous traitons de la photo de profil et procédons à un redimensionnement.
 * Pour cela nous prenons la dimension la plus grande (hauteur ou largeur) et nous la ramenons à 75px.
 * Nous gardons le rapport hauteur/largeur pour préserver l'image.
 *
 * @param int $userId
 * 
 * @return void
 */
function updatingUser($userId)
{

	$userManager = new P4\model\UsersManager();
	
	// Test log
	if (isset($_POST['pseudo']) && strlen($_POST['pseudo']) != 0) {

		if (strlen($_POST['pseudo']) > 3) {

			if ($_POST['pseudo'] != $_SESSION['login']) {

				if ($userManager->exists($_POST['pseudo'])) {

					header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=loginused');

				} else {

					$pseudo = htmlspecialchars($_POST['pseudo']);
				}

			} else {

				$pseudo = $_SESSION['login'];
			}

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=loginshort');
		}

	} else {

		$pseudo = $_SESSION['login'];
	} 
	
	// Test email
	if (isset($_POST['email']) && strlen($_POST['email']) != 0) {

		if ($_POST['email'] != $_SESSION['email']) {

			if ($userManager->existMail($_POST['email'])) {

				header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=mailused');

			} else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {

				header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=mailmirror');

			} else {

				$email = htmlspecialchars($_POST['email']);
			}

		} else {

			$email = $_SESSION['email'];
		}
	} else {

		$email = $_SESSION['email'];
	}
	
	// Test password
	if (isset($_POST['mdp1']) && strlen($_POST['mdp1']) != 0 && isset($_POST['mdp2']) && strlen($_POST['mdp2']) != 0 && isset($_POST['mdp3']) && strlen($_POST['mdp3']) != 0) {

		if ($_POST['mdp1'] != $_POST['mdp2']) {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=passwordmirror');

		} else {

			$isPasswordCorrect = password_verify($_POST['mdp2'], $_SESSION['password']);

			if ($isPasswordCorrect) {

				if (strlen($_POST['mdp3']) >= 6) {

					$mdp3 = htmlspecialchars($_POST['mdp3']);
					$password = password_hash($mdp3, PASSWORD_DEFAULT);

				} else {

					header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=passwordshort');
				}

			} else {

				header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=passwordwrong');
			}
		}

	} else {

		$password = $_SESSION['password'];
	}
	
	// Test Country
	if (isset($_POST['country']) && strlen($_POST['country']) != 0) {

		$country = htmlspecialchars($_POST['country']);

	} else {

		$country = $_SESSION['country'];
	}
	
	// Suppression ou Upload et redim de l'image envoyée
	if (isset($_POST['deleteUserAvatar'])) {

		$avatar_path = 'public/images/user_avatar/0.jpeg';

	} else if (isset($_FILES['userImage']) && !empty($_FILES['userImage'])) {

		if ($_FILES['userImage']['error'] == 0) {

			if ($_FILES['userImage']['size'] <= 2097152) {

				$userImage = $_FILES['userImage']['name'];

				$ListeExtension = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif');
				$ListeExtensionIE = array('jpg' => 'image/pjpg', 'jpeg' => 'image/pjpeg');

				$ExtensionPresumee = explode('.', $userImage);
				$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee) - 1]);

				if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg' || $ExtensionPresumee == 'pjpg' || $ExtensionPresumee == 'pjpeg' || $ExtensionPresumee == 'gif' || $ExtensionPresumee == 'png') {

					$userImage = getimagesize($_FILES['userImage']['tmp_name']);

					if ($userImage['mime'] == $ListeExtension[$ExtensionPresumee] || $userImage['mime'] == $ListeExtensionIE[$ExtensionPresumee]) {

						if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg') {

							$newUserImage = imagecreatefromjpeg($_FILES['userImage']['tmp_name']);

						} else if ($userImage['mime'] == 'image/png') {

							$newUserImage = imagecreatefrompng($_FILES['userImage']['tmp_name']);

						} else if ($userImage['mime'] == 'image/gif') {

							$newUserImage = imagecreatefromgif($_FILES['userImage']['tmp_name']);

						} else {

							header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=imagewrong');
						}

						$sizeNewUserImage = getimagesize($_FILES['userImage']['tmp_name']);

						$width = $sizeNewUserImage[0];
						$height = $sizeNewUserImage[1];
						$avatarSide = 75;
						if ($width >= $height) {

							$newWidth = $avatarSide;
							$Reduction = (($newWidth * 100) / $width);
							$newHeight = (($height * $Reduction) / 100);

						} else if ($height > $width) {

							$newHeight = $avatarSide;
							$Reduction = (($newHeight * 100) / $height);
							$newWidth = (($width * $Reduction) / 100);
						}

						$userAvatar = imagecreatetruecolor($newWidth, $newHeight) or die("Erreur");
						imagecopyresampled($userAvatar, $newUserImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
						imagedestroy($newUserImage);


						if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg') {

							imagejpeg($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);

						} else if ($userImage['mime'] == 'image/png') {

							imagepng($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 6);

						} else if ($userImage['mime'] == 'image/gif') {

							imagegif($userAvatar, 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee, 100);
						}

						$avatar_path = 'public/images/user_avatar/' . $_SESSION['userId'] . '.' . $ExtensionPresumee;

					} else {

						header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=imagewrong');
					}

				} else {

					header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=imagewrong');
				}

			} else {

				header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=imagesize');
			}

		} else if ($_FILES['userImage']['error'] == 4) {// Le code erreur 4 signifie pas de fichier

			$avatar_path = $_SESSION['avatar_path'];

		} else {

			header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&error=uploaderror');
		}

	} else {

		$avatar_path = $_SESSION['avatar_path'];
	}
	
	
	//Test OK -> Upload
	$userManager->updateUserInfo($_SESSION['userId'], $pseudo, $email, $password, $country, $avatar_path);
	sessionUser($pseudo);
	header('location:http://jeanforteroche.code-one.fr/index.php?action=userProfil&success=true');
}

/**
 * Fonction de désincription du blog
 * Permet à l'utilisateur de supprimer son compte du blog
 *
 * @param int $userId
 * @return void
 */
function signOut($userId)
{

	$password = htmlspecialchars($_POST['password']);

	$isPasswordCorrect = password_verify($password, $_SESSION['password']);

	if ($isPasswordCorrect) {

		$userManager = new P4\model\UsersManager();
		$userManager->deleteUser($_SESSION['userId']);

		session_destroy();
		setcookie('login', '');
		setcookie('password', '');
		header('Location:index.php');

	} else {

		$adress = $_SERVER['HTTP_REFERER'];

		if (($adress == 'http://jeanforteroche.code-one.fr/index.php') || $adress == 'http://jeanforteroche.code-one.fr/') {

			$adress = 'http://jeanforteroche.code-one.fr/index.php?';

		} else {

			$adress = $_SERVER['HTTP_REFERER'] . '&';
		}

		header('location:' . $adress . 'action=userProfil&log=signOutError');
	}
}

/**
 * Fonction qui permet d'affiicher la liste des membres quand on clique
 * sur le line "Membres"
 *
 * @return void
 */
function usersList()
{

	$userManager = new P4\model\UsersManager();
	$users = $userManager->usersList();
	require('view/frontend/usersListView.php');
}


?>