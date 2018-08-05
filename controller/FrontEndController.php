<?php

namespace P4\controller;

use P4\model\UsersManager;
use P4\model\CommentsManager;
use P4\model\PostsManager;

/**
 * Controle les entrées qui proviennent de la partie publique du site
 */
class FrontEndController
{

	/**
	 * Fonction de base qui affiche la page d'accueil
	 *
	 * @return void
	 */
	public static function homePage()
	{
		require('view/frontend/homepageView.php');
	}

	/**
	 * Permet l'affichage des récits
	 *
	 * @return void
	 */
	public static function listPosts()
	{
		$postsManager = new \P4\model\PostsManager();
		$posts = $postsManager->getPosts();
		require('view/frontend/ListPostsView.php');
	}

	/**
	 * Permet l'affichage d'un récit en entier
	 *
	 * @param int $id
	 * @return void
	 */
	public static function post($id) //----------------- une modal -----------------------
	{
		$postsManager = new \P4\model\PostsManager();

		if ($postsManager->existsID($id)) {

			$post = $postsManager->getPost($id);
			$commentsManager = new \P4\model\CommentsManager();
			$comments = $commentsManager->getComments($id);
			require('view/frontend/postView.php');

		} else {

			header('location:' . $GLOBALS['url'] . '?action=listPosts&');//---------------------------------------------------------------------------------------------------
		}
	}

	/**
	 * Demand ed'inscription d'un abonné
	 *
	 * @param string $login
	 * @param string $mdp1
	 * @param string $mdp2
	 * @param string $email
	 * @return void
	 */
	public static function newUser($login, $mdp1, $mdp2, $email)
	{	
		$login = htmlspecialchars($_POST['login']);
		$mdp1 = htmlspecialchars($_POST['mdp1']);
		$mdp2 = htmlspecialchars($_POST['mdp2']);
		$email = htmlspecialchars($_POST['mail_user']);

		$userManager = new UsersManager();

		$adress = $_SERVER['HTTP_REFERER'];

		if ($adress == $GLOBALS['url']) {
			$adress = $GLOBALS['url'] . '?';

		} else {

			$adress = $_SERVER['HTTP_REFERER'] . '&';

		}

		if ($userManager->exists($login)) {
			
			header('location:' . $adress . 'src=signformError&log=loginused');

		} else if (strlen($login) < 3) {

			header('location:' . $adress . 'src=signformError&log=loginshort');

		} else if ($mdp1 != $mdp2) {

			header('location:' . $adress . 'src=signformError&log=passwordmirror');

		} else if (strlen($mdp2) <= 5) {

			header('location:' . $adress . 'src=signformError&log=passwordshort');

		} else if ($userManager->existMail($email)) {

			header('location:' . $adress . 'src=signformError&log=mailused');

		} else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {

			header('location:' . $adress . 'src=signformError&log=mailmirror');

		} else {

			$password = password_hash($mdp2, PASSWORD_DEFAULT);
			$affectedUser = $userManager->addNewUser($login, $password, $email);
			$_SESSION['login'] = $login;
			self::sessionUser($_SESSION['login']);
			header('location:' . $adress . 'src=signformSuccess&log=signed');
		}
	}

	/**
	 * Connexion d'un abonné
	 *
	 * @param string $login
	 * @param string $password
	 * @param int $cookied
	 * @return void
	 */
	public static function logUser($login, $password, $cookied)
	{
		$login = htmlspecialchars($_POST['pseudo']);
		$password = htmlspecialchars($_POST['mdp']);

		$userManager = new \P4\model\UsersManager();

		$adress = $_SERVER['HTTP_REFERER'];

		if ($adress == $GLOBALS['url']) {
			$adress = $GLOBALS['url'] . '?';

		} else {

			$adress = $_SERVER['HTTP_REFERER'] . '&';

		}
		
		if ($userManager->exists($login)) {
			
			$infoUser = $userManager->userInfos($login);
			
			$isPasswordCorrect = password_verify($password, $infoUser['password']);

			if ($isPasswordCorrect) {

				if ($infoUser['ban'] == 1) {

					header('location:' . $adress . 'src=userBanned');

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
				}
			} else {
				header('location:' . $adress . 'src=logInError');
			}
		} else {
			header('location:' . $adress . 'src=logInError');
		}
	}

	/**
	 * Affiche la vue de personnalisation du profil
	 *
	 * @return void
	 */
	public static function userProfil()
	{
		require('view/frontend/userProfilView.php');
	}

	/**
	 * Complète les variables de session
	 *
	 * @param string $login
	 * @return void
	 */
	public static function sessionUser($login)
	{
		$userManager = new UsersManager();
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
	 * Met à jour le profil de l'utilisateur
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function updatingUser($userId)
	{

		$userManager = new UsersManager();
		
		if (isset($_POST['pseudo']) && strlen($_POST['pseudo']) != 0) {

			if (strlen($_POST['pseudo']) > 3) {

				if ($_POST['pseudo'] != $_SESSION['login']) {

					if ($userManager->exists($_POST['pseudo'])) {

						header('location:' . $GLOBALS['url'] . '?action=userProfil&error=loginused');

					} else {

						$pseudo = htmlspecialchars($_POST['pseudo']);
					}
				} else {

					$pseudo = $_SESSION['login'];
				}
			} else {

				header('location:' . $GLOBALS['url'] . '?action=userProfil&error=loginshort');
			}
		} else {

			$pseudo = $_SESSION['login'];
		}
		
		if (isset($_POST['email']) && strlen($_POST['email']) != 0) {
			
			if ($_POST['email'] != $_SESSION['email']) {

				if ($userManager->existMail($_POST['email'])) {

					header('location:' . $GLOBALS['url'] . '?action=userProfil&error=mailused');
					
				} else if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {

					header('location:' . $GLOBALS['url'] . '?action=userProfil&error=mailmirror');

				} else {

					$email = htmlspecialchars($_POST['email']);
				}
			} else {

				$email = $_SESSION['email'];
			}
		} else {

			$email = $_SESSION['email'];
		}

		if (isset($_POST['mdp1']) && strlen($_POST['mdp1']) != 0 && isset($_POST['mdp2']) && strlen($_POST['mdp2']) != 0 && isset($_POST['mdp3']) && strlen($_POST['mdp3']) != 0) {

			if ($_POST['mdp1'] != $_POST['mdp2']) {
				
				header('location:' . $GLOBALS['url'] . '?action=userProfil&error=passwordmirror');

			} else {
				
				$isPasswordCorrect = password_verify($_POST['mdp2'], $_SESSION['password']);

				if ($isPasswordCorrect) {

					if (strlen($_POST['mdp3']) >= 6) {

						$mdp3 = htmlspecialchars($_POST['mdp3']);
						$password = password_hash($mdp3, PASSWORD_DEFAULT);

					} else {
						header('location:' . $GLOBALS['url'] . '?action=userProfil&error=passwordshort');
					}
				} else {
					header('location:' . $GLOBALS['url'] . '?action=userProfil&error=passwordwrong');
				}
			}
		} else {
			$password = $_SESSION['password'];
		}
		
		if (isset($_POST['country']) && strlen($_POST['country']) != 0) {

			$country = htmlspecialchars($_POST['country']);

		} else {

			$country = $_SESSION['country'];
		}
		
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

					if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg' || $ExtensionPresumee == 'pjpg' || $ExtensionPresumee == 'pjpeg' || $ExtensionPresumee == 'gif' || $ExtensionPresumee == 'png')	{

						$userImage = getimagesize($_FILES['userImage']['tmp_name']);

						if ($userImage['mime'] == $ListeExtension[$ExtensionPresumee] || $userImage['mime'] == $ListeExtensionIE[$ExtensionPresumee]) {
							
							if ($userImage['mime'] == 'image/jpg' || $userImage['mime'] == 'image/jpeg' || $userImage['mime'] == 'image/pjpg' || $userImage['mime'] == 'image/pjpeg') {

								$newUserImage = imagecreatefromjpeg($_FILES['userImage']['tmp_name']);

							} else if ($userImage['mime'] == 'image/png') {

								$newUserImage = imagecreatefrompng($_FILES['userImage']['tmp_name']);

							} else if ($userImage['mime'] == 'image/gif') {

								$newUserImage = imagecreatefromgif($_FILES['userImage']['tmp_name']);

							} else {
								
								header('location:' . $GLOBALS['url'] . '?action=userProfil&error=imagewrong');
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

							header('location:' . $GLOBALS['url'] . '?action=userProfil&error=imagewrong');
						}
					} else {
						// l'extension du fichier n'est pas valide
						header('location:' . $GLOBALS['url'] . '?action=userProfil&error=imagewrong');
					}
				} else {
					
					header('location:' . $GLOBALS['url'] . '?action=userProfil&error=imagesize');
				}
			} else if ($_FILES['userImage']['error'] == 4) {

				$avatar_path = $_SESSION['avatar_path'];

			} else {

				header('location:' . $GLOBALS['url'] . '?action=userProfil&error=uploaderror');
			}
		} else {

			$avatar_path = $_SESSION['avatar_path'];
		}
		$userManager->updateUserInfo($_SESSION['userId'], $pseudo, $email, $password, $country, $avatar_path);
		FrontEndController::sessionUser($pseudo);
		header('location:' . $GLOBALS['url'] . '?action=userProfil&success=true');
	}


	/**
	 * L'abonné supprime son compte
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function signOut($userId)
	{
		$password = htmlspecialchars($_POST['password']);

		$isPasswordCorrect = password_verify($password, $_SESSION['password']);

		if ($isPasswordCorrect) {

			$userManager = new P4\model\UsersManager();
			$userManager->deleteUser($_SESSION['userId']);
			session_destroy();
			setcookie('login', '');
			setcookie('password', '');
			header('Location:' . $GLOBALS['url']);

		} else {
			
			header('location:' . $GLOBALS['url'] . '?action=userProfil&log=signOutError');
		}
	}

	/**
	 * Permet l'affichage de l'ensemble des abonnés du blog
	 *
	 * @return void
	 */
	public static function usersList()
	{
		$userManager = new UsersManager();
		$users = $userManager->usersList();
		require('view/frontend/usersListView.php');
	}
}