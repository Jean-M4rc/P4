<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link href="public/css/lux.min.css" rel="stylesheet" />
        <link href="public/css/style.css" rel="stylesheet" />
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
    </head>
        
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="http://localhost/P4/index.php">Jérôme Forteroche | <i class="fas fa-home"></i></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarColor02">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="http://localhost/P4/index.php?action=listPosts">Mes aventures</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Mon livre d'Or</a>
					</li>
				</ul>
	<?php
		// Si le visiteur est connecté par sa session ou son cookie on modifie le menu de navigation
		if (isset($_SESSION['login'])||isset($_COOKIE['login'])){
	?>
				<div class="btngroup">
					<a href='http://localhost/P4/index.php?action=userProfil'><button class="btn btn-outline-secondary" type="button"><i class="fas fa-user-edit"></i> Mon profil</button></a>
					<button class="btn btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#logOutModal"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
					<!-- au lieu du lien mettre une modal qui demande la confirmation de la déconnexion -->
				</div>

	<?php
		// S'il n'est pas connecté on affiche le menu de base
		} else {
	?>
				<div class="btngroup">
					<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#signInModal"><i class="fas fa-user-plus"></i> Inscription</button>
					<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#logInModal"><i class="fas fa-user-check"></i> Connexion</button>
				</div>	
	<?php
		}
	?>	
			</div>
		</nav>
		
		<!--  ----  Modals ---- -->
		
		<!-- Modal -- logOutModal -->
		<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="LogOutModalCenter" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalCenterTitle">Déconnexion</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="http://localhost/P4/index.php?action=logOut">
						<fieldset>
							<div class="modal-body">
								<div class="alert alert-danger text-center" role="alert">
								Confirmez votre déconnexion. Vous pourrez vous reconnecter ultérieurement.
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
								<input class="btn btn-primary" id="submit" type="submit" value="Déconnexion">
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End LogOutModal -->

		<!-- Modal -- signInModal -->
		<div class="modal fade" id="signInModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenteredForSignIn" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form role="form" data-toggle="validator" method="post" action="http://localhost/P4/index.php?action=signin">
						<fieldset>
							<div class="modal-header">
								<h2 class="modal-title">Rejoignez l'aventure !</h2>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div><!-- modal header -->
							<div class="modal-body">
								<div class="form-group"><!-- le login -->
									<label for="login" class="control-label">Pseudo :</label>
									<input class="form-control" id="login" name="login" type="text" pattern=".{3,}" data-error="Votre pseudo est trop court !" required>
									<div class="help-block">Minimum 3 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group"><!-- le mot de passe -->
									<label for="mdp1" class="control-label">Mot de passe : </label>
									<input class="form-control" id="mdp1" name="mdp1" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !" required>
									<div class="help-block">Minimum 6 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group"><!-- la confirmation du mot de passe -->
									<label for="mdp2" class="control-label">Confirmez votre mot de passe : </label>
									<input class="form-control" data-match="#mdp1" id="mdp2" name="mdp2" type="password" data-match-error="Les mots de passes ne correspondent pas !"required>
									<div class="help-block with-errors"></div>
									
								</div>
								<div class="form-group"><!-- le mail -->
									<label for="mail" class="control-label">Votre adresse mail :</label>
									<input class="form-control" id="mail" name="mail_user" type="email" aria-describedby="emailHelp" data-error="Attention, votre adresse email n'est pas valide" required>
									<small id="emailHelp" class="form-text text-muted">Nous ne transmettrons jamais votre adresse mail à un tiers.</small>
									<div class="help-block with-errors"></div>
								</div>
								<div class="g-recaptcha d-flex justify-content-center" data-sitekey="6LcRllwUAAAAACkks2ZBKPn38QORzdjCjFxB_uVZ"></div>
							</div><!-- modal-body -->
							<div class="modal-footer">
								<div class="form-group">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
									<input type="submit" class="btn btn-primary" id="submit" value="Envoyer votre demande d'inscription">
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End signInModal -->
		
		<!-- Modal -- logInModal -->
		<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="LogInModalCenter" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalCenterTitle">Connexion</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" data-toggle="validator" action="http://localhost/P4/index.php?action=login">
						<fieldset>
							<div class="modal-body">
								<div class="form-group"><!-- Le log -->
									<label for="pseudo" class="control-label">Pseudo : </label>
									<input id="pseudo" class="form-control" name="pseudo" type="text" pattern=".{3,}" data-error="Votre pseudo est trop court !" required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group"><!-- le mot de passe -->
									<label class="control-label">Mot de passe : </label>
									<input id="mdp" class="form-control" name="mdp" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !" required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<div class="form-check checkbox">
										<label class="from-check-label">
											<input type="checkbox" class="form-check-input" id="ca" value="1" name="CA">
											Connexion automatique
										</label>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
								<input class="btn btn-primary" id="submit" type="submit" value="Connexion">
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End logInModal -->
		
		<?php 
		include('view/partial/modalView.php');
		?>

        <?= $content ?>
		
		<?php
		include('view/partial/footerView.php');
		?>

    </body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="public/js/validator.js"></script>
	<script src="public/js/anim.js"></script>
</html>