<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="description" content="Blog de l'écrivain Jean Forteroche. Aventurier en Alaska il nous raconte ses aventures"/> 
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title><?= $title ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/>
		<link href="public/css/lux.min.css" rel="stylesheet" />
        <link href="public/css/style.css" rel="stylesheet" />
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head> 
    <body>
		<nav class="navbar navbar-expand-xl navbar-dark bg-dark">
<<<<<<< HEAD
			<a class="navbar-brand" href="http://jeanforteroche.code-one.fr/index.php">Jean Forteroche | <i class="fas fa-home"></i></a>
=======
			<a class="navbar-brand" href="<?= $GLOBALS['url'] ?>">Jean Forteroche | <i class="fas fa-home"></i></a>
>>>>>>> poo_transform
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarColor02">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
<<<<<<< HEAD
						<a class="nav-link" href="http://jeanforteroche.code-one.fr/index.php?action=listPosts">Mes aventures</a>
=======
						<a class="nav-link" href="<?= $GLOBALS['url'] ?>?action=listPosts">Mes aventures</a>
>>>>>>> poo_transform
					</li>
<?php
	if (isset($_SESSION['login'])||isset($_COOKIE['login'])) {
?>
					<li class="nav-item">
<<<<<<< HEAD
						<a class="nav-link" href="http://jeanforteroche.code-one.fr/index.php?action=usersList">Membres</a>
=======
						<a class="nav-link" href="<?= $GLOBALS['url'] ?>?action=usersList">Membres</a>
>>>>>>> poo_transform
					</li>
<?php
	}
?>
				</ul>
				<div class="btngroup">
<<<<<<< HEAD
	<?php
		// Si le visiteur est connecté par sa session ou son cookie on modifie le menu de navigation
		if (isset($_SESSION['login'])||isset($_COOKIE['login'])){
			
			if ($_SESSION['rule'] >= 1){
	?>
				<a href='http://jeanforteroche.code-one.fr/index.php?action=pandOra'><button class="btn btn-outline-success mr-1 my-1" type="button"><i class="fas fa-user-edit"></i> Administration</button></a>
	<?php			
			}
	?>
				
				<a href='http://jeanforteroche.code-one.fr/index.php?action=userProfil'><button class="btn btn-outline-secondary mr-1 my-1" type="button"><i class="fas fa-user-edit"></i> Mon profil</button></a>
				<button class="btn btn btn-outline-secondary my-1" type="button" data-toggle="modal" data-target="#logOutModal"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
				
=======
<?php
	if (isset($_SESSION['login'])||isset($_COOKIE['login'])) {
>>>>>>> poo_transform

		if ($_SESSION['rule'] >= 1) {
?>
					<a href='<?= $GLOBALS['url'] ?>?action=pandOra'><button class="btn btn-outline-success mr-1 my-1" type="button"><i class="fas fa-user-edit"></i> Administration</button></a>
<?php			
		}
?>
				
					<a href='<?= $GLOBALS['url'] ?>?action=userProfil'><button class="btn btn-outline-secondary mr-1 my-1" type="button"><i class="fas fa-user-edit"></i> Mon profil</button></a>
					<button class="btn btn btn-outline-secondary my-1" type="button" data-toggle="modal" data-target="#logOutModal"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
<?php
	} else {
?>
					<button class="btn btn-outline-secondary mr-1 my-1" type="button" data-toggle="modal" data-target="#signInModal"><i class="fas fa-user-plus"></i> Inscription</button>
					<button class="btn btn-outline-secondary my-1" type="button" data-toggle="modal" data-target="#logInModal"><i class="fas fa-user-check"></i> Connexion</button>				
<?php
	}
?>	
				</div>
			</div>
		</nav>
	
		<!-- logOutModal -->
		<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="LogOutModalCenter" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalCenterTitle">Déconnexion</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
<<<<<<< HEAD
					<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=logOut"> 
=======
					<form method="post" action="<?= $GLOBALS['url'] ?>?action=logOut"> 
>>>>>>> poo_transform
						<fieldset>
							<div class="modal-body">
								<div class="alert alert-danger text-center" role="alert">
								Confirmez votre déconnexion. Vous effacerez aussi vos cookies par cette action. Vous pourrez vous reconnecter ultérieurement. 
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
								<input class="btn btn-primary" id="submit" type="submit" value="Déconnexion">
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End LogOutModal -->

		<!-- signInModal -->
		<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenteredForSignIn" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
<<<<<<< HEAD
					<form role="form" data-toggle="validator" method="post" action="http://jeanforteroche.code-one.fr/index.php?action=signin">
=======
					<form role="form" data-toggle="validator" method="post" action="<?= $GLOBALS['url'] ?>?action=signin">
>>>>>>> poo_transform
						<fieldset>
							<div class="modal-header">
								<h2 class="modal-title">Rejoignez l'aventure !</h2>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<!-- le login -->
								<div class="form-group">
									<label for="login" class="control-label">Pseudo :</label>
									<input class="form-control" id="login" name="login" type="text" pattern=".{3,}" data-error="Votre pseudo est trop court !" required>
									<div class="help-block">Minimum 3 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<!-- le mot de passe -->
								<div class="form-group">
									<label for="mdp1" class="control-label">Mot de passe : </label>
									<input class="form-control" id="mdp1" name="mdp1" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !" required>
									<div class="help-block">Minimum 6 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<!-- la confirmation du mot de passe -->
								<div class="form-group">
									<label for="mdp2" class="control-label">Confirmez votre mot de passe : </label>
									<input class="form-control" data-match="#mdp1" id="mdp2" name="mdp2" type="password" data-match-error="Les mots de passes ne correspondent pas !"required>
									<div class="help-block with-errors"></div>
									
								</div>
								<!-- le mail -->
								<div class="form-group">
									<label for="mail" class="control-label">Votre adresse mail :</label>
									<input class="form-control" id="mail" name="mail_user" type="email" aria-describedby="emailHelp" data-error="Attention, votre adresse email n'est pas valide" required>
									<small id="emailHelp" class="form-text text-muted">Nous ne transmettrons jamais votre adresse mail à un tiers.</small>
									<div class="help-block with-errors"></div>
								</div>
<<<<<<< HEAD
								<div class="g-recaptcha d-flex justify-content-center" data-sitekey="6LdYUlwUAAAAAAC5xhS_Ta72loK4qTWf7ESVgpzJ"></div>
=======
								<!-- Google ReCaptcha -->
								<div class="g-recaptcha d-flex justify-content-center" data-sitekey="<?= $GLOBALS['siteKey']; ?>"></div>
>>>>>>> poo_transform
								<br/>
								<!-- infobox -->
								<div class="alert alert-dismissible alert-primary">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <h4 class="alert-heading">Attention</h4>
								  <p class="mb-0">Ce site est susceptible d'utiliser des cookies.</p>
								</div>
							</div>
							<div class="modal-footer">
								<div class="form-group">
									<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
									<input type="submit" class="btn btn-primary" id="submit" value="Envoyer votre demande d'inscription">
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End signInModal -->
		
		<!-- logInModal -->
		<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="LogInModalCenter" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalCenterTitle">Connexion</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
<<<<<<< HEAD
					<form method="post" data-toggle="validator" action="http://jeanforteroche.code-one.fr/index.php?action=login">
=======
					<form method="post" data-toggle="validator" action="<?= $GLOBALS['url'] ?>?action=login">
>>>>>>> poo_transform
						<fieldset>
							<div class="modal-body">
								<!-- Le log -->
								<div class="form-group">
									<label for="pseudo" class="control-label">Pseudo : </label>
									<input id="pseudo" class="form-control" name="pseudo" type="text" pattern=".{3,}" data-error="Votre pseudo est trop court !" required />
									<div class="help-block with-errors"></div>
								</div>
								<!-- le mot de passe -->
								<div class="form-group">
									<label class="control-label">Mot de passe : </label>
									<input id="mdp" class="form-control" name="mdp" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !" required />
									<div class="help-block with-errors"></div>
								</div>
								<!-- cookiebox -->
								<div class="alert alert-primary">
									<h4 class="alert-heading">Attention</h4>
									<div class="form-group">
										<div class="form-check checkbox">
											<label class="from-check-label">
												<input type="checkbox" class="form-check-input" id="ca" value="1" name="CA">
											Se souvenir de moi.
											</label>
										</div>
										<p class="mb-0">Cocher l'option "Se souvenir de moi" permettra de mémoriser des cookies pour améliorer votre expérience. Si vous voulez supprimer ces cookies cliquez sur le bouton "Déconnexion".</p>	
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
								<input class="btn btn-primary" id="submit" type="submit" value="Connexion">
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End logInModal -->
		
<?php 
	include('helper/modalindex.php');
	echo $content;
	include('view/partial/footerFrontView.php');
?>

    </body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="public/js/validator.js"></script>
	<script src="public/js/anim.js"></script>
</html>