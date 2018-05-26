<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link href="public/css/lux.min.css" rel="stylesheet" />
        <link href="public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php">Jérôme Forteroche</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarColor02">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="http://localhost/P4/index.php">Accueil <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Mes aventures</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Mon livre d'Or</a>
					</li>
				</ul>
	<?php
		// Si le visiteur est connecté par sa session ou son cookie on modifie le menu de navigation
		if (isset($_SESSION['pseudo'])||isset($_COOKIE['pseudo'])){
	?>
				<div class="btngroup">
					<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#userProfilModal"><i class="fas fa-user-edit"></i> Mon profil</a></button><!-- icone FA de mon profil -->
					<a href="#"><button class="btn btn btn-outline-secondary" type="button"><i class="fas fa-sign-out-alt"></i> Déconnexion</button></a><!-- icone FA de déconnexion -->
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
		
		<!-- Ici un bandeau contenant les messages d'erreurs recu par le serveur, les modales n'étant pas accessible facilement par le php -->
		
		<?php  if (isset($_GET['erreur']) && isset($message)){?>
			<div class="alert alert-dismissible alert-warning">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4 class="alert-heading">Attention !</h4>
				<p class="mb-0"><?= $message; ?></p>
			</div>
		<?php } ?>
		
		<!-- Modal -> signInModal -->
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
									
									<?php  if (isset($_GET['erreurpseudo'])){echo "<span class='alert'>Le pseudo est déjà utilisé</span>";} ?>
									
									<input class="form-control" id="login" name="login" type="text" pattern=".{3,}" data-error="Votre pseudo est trop court !" required>
									<div class="help-block">Minimum 3 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group"><!-- le mot de passe -->
									<label for="mdp1" class="control-label">Mot de passe : </label>
									
									<?php if (isset($_GET['erreurmdp'])){echo "<span class='alert'>Les mot de passe ne sont pas identiques</span>";} ?>
									
									<input class="form-control" id="mdp1" name="mdp1" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !" required>
									<div class="help-block">Minimum 6 caractères</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group"><!-- la confirmation du mot de passe -->
									<label for="mdp2" class="control-label">Confirmez votre mot de passe : </label>
									<input class="form-control" data-match="#mdp1" id="mdp2" name="mdp2" type="password" data-match-error="Oupss, les mots de passes ne correspondent pas !"required>
									<div class="help-block with-errors"></div>
									
								</div>
								<div class="form-group"><!-- le mail -->
									<label for="mail" class="control-label">Votre adresse mail :</label>
									
									<?php if (isset($_GET['erreurmail'])){echo "<span class='alert'>L'adresse mail n'est pas valide</span>";} ?>
									
									<input class="form-control" id="mail" name="mail_user" type="email" aria-describedby="emailHelp" data-error="Bruh, that email address is invalid" required>
									<small id="emailHelp" class="form-text text-muted">Nous ne transmettrons jamais votre adresse mail à un tiers.</small>
									<div class="help-block with-errors"></div>
								</div>
								
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
					<form method="post" data-toggle="validator" action="connexion_post.php">
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
											<input type="checkbox" class="form-check-input" id="ca" name="ca">
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
		<!-- End LogInModal -->

        <?= $content ?>
		
		<footer>
			<div class="card border-primary mb-3" style="max-width: 20rem;">
				<div class="card-header">Mon dernier Récit</div>
					<div class="card-body">
						<h4 class="card-title">Le titre du dernier billet</h4>
						<p class="card-text">Le résumé du dernier billet</p>
					</div>
			</div>
			<div class="card border-primary mb-3" style="max-width: 20rem;">
				<div class="card-header">Le dernier commentaire posté</div>
				<div class="card-body">
					<h4 class="card-title">L'auteur et le titre du billet</h4>
					<p class="card-text">Le résumé du commentaire</p>
				</div>
			</div>
			<div class="card border-primary mb-3" style="max-width: 20rem;">
				<div class="card-header">Plus d'aventure ?</div>
				<div class="card-body">
					<h4 class="card-title">Me suivre sur les réseaux</h4>
					<p class="card-text">Icone avec liens facebook etc</p>
				</div>
			</div>
		</footer>
		
    </body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="public/js/validator.js"></script>
</html>