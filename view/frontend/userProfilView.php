<?php $title='Mon profil'; ?>

<?php ob_start(); ?>

	<h1>Mon Profil</h1>
	<p class="lead pintro text-center">Vous trouverez ici les informations de votre profil.<br/>Vous pouvez les modifier ou les corriger.</p>
	<hr class="my-4">
<!-- on va utiliser les $_SESSION ici -->
	<div class="container-fluid">
		<div class="row ">
			<div class="card text-white text-center bg-primary mb-3 mx-auto" style="width: 20rem;">
				<div class="card-header">Mes informations actuelles</div>
				<div class="card-body">
					<h4 class="card-title">Pseudo : <?= $_SESSION['login'] ?></h4>
					<p class="card-text">Mon avatar :</p>
					<p class="card-text"><img class="mx-auto" style="display:block;" src="<?= $_SESSION['avatar_path'] ?>" alt="Votre photo de profil"/></p>
					<p class="card-text">Email : <?= $_SESSION['email'] ?></p>
					<p class="card-text">Pays : <?= $_SESSION['country'] ?></p>
					<p class="card-text">Compte créé le <?= $_SESSION['date_sign'] ?></p>
					<p class="card-text">Nombre de messages postés : <span class="badge badge-pill badge-light">A définir <!--<?= $_SESSION['msgcount'] ?>--></span></p>
				</div>
				<div class="card-footer">
				<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#signOutModal"><i class="fas fa-user-slash"></i> Supprimer mon profil</button>
				</div>
			</div>
			<div class="jumbotron mb-3">
				<h3 class="display-7">Renseigner les champs à modifier</h3>
				<hr class="my-4">
				<form role="form" method="post" data-toggle="validator" enctype="multipart/form-data" action="http://localhost/P4/index.php?action=updateProfil">
					<fieldset>
						<!-- Update du pseudo -->
						<div class="form-group">
							<label for="pseudo">Votre pseudo</label>
							<input class="form-control" name="pseudo" type="text" pattern=".{3,}" data-error="Votre nouveau pseudo est trop court !" placeholder="<?= $_SESSION['login'] ?>">
							<div class="help-block">Minimum 3 caractères</div>
							<div class="help-block with-errors"></div>
						</div>
						<!-- Update de l'email -->
						<div class="form-group">
							<label for="email">Email</label>
							<input class="form-control" id="email" name="email" type="email" placeholder="<?= $_SESSION['email'] ?>" data-error="Cet adresse mail n'est pas valide">
							<div class="help-block with-errors"></div>
						</div>
						<!-- Update du mot de passe -->
						<div class="form-group row">
							<div class="form-group col-sm-12 col-md-4">
								<label for="mdp1">Entrez votre ancien mot de passe</label>
								<input class="form-control" id="password1" name="mdp1" type="password">
							</div>
							<div class="form-group col-sm-12 col-md-4">							
								<label for="mdp2">Répétez votre ancien mot de passe</label>
								<input class="form-control" id="mdp2" name="mdp2" data-match="#password1" type="password" data-match-error="Les mots de passes ne correspondent pas !">
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group col-sm-12 col-md-4">
								<label for="mdp3">Entrez votre nouveau mot de passe</label>
								<input class="form-control" id="mdp3" name="mdp3" type="password" pattern=".{6,}" data-error="Votre mot de passe est trop court !">
								<div class="help-block">Minimum 6 caractères</div>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<!-- Pays/Ville  de l'utilisateur -->
						<div class="form-group">
							<label for="localisation">Pays / Ville</label>
							<input class="form-control" id="country" name="country" type="text" placeholder="<?= $_SESSION['country'] ?>" >
						</div>
						<!-- Upload de l'image de profil -->
						<div class="form-group">
							<label for="image">Télécharger votre avatar</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="2097152"/>
							<input type="file" class="form-control-file" name="userImage" id="image" aria-describedby="fileHelp" >
							Supprimer votre photo : <input type="checkbox" name="deleteUserAvatar" value="delete"/>
							<small id="fileHelp" class="form-text text-muted">Attention l'image ne doit pas excéder 2 Mo. Et elle peut être soumise à modération.</small>
						</div>
						<!-- Validation du formulaire ou reset -->
						<p class="lead text-right">
							<button type="reset" class="btn btn-secondary">Annuler</button>
							<button type="submit" class="btn btn-primary">Mettre à jour<span class="d-none d-sm-inline"> vos informations</span></button>
						</p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	
<!-- signOutModal -->
			<div class="modal fade" id="signOutModal" tabindex="-1" role="dialog" aria-labelledby="signOutModalCenter" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalCenterTitle">Suppression</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" action="http://localhost/P4/index.php?action=signOut"> 
							<fieldset>
								<div class="modal-body">
									<div class="alert alert-danger text-center" role="alert">
									Etes-vous sûr de vouloir supprimer votre profil ?<br/>
									Toutes vos données (sauf vos commentaires) seront effacées. 
									</div>
									<div class="form-group">
										<label for="mdp1">Entrez votre mot de passe</label>
										<input class="form-control" id="password" name="password" type="password">
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
									<input class="btn btn-primary" id="submit" type="submit" value="Supprimer">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>