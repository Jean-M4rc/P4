<?php
	if(isset($_GET['src'])) // Si nous avons une indication dans l'url
	{ 
		if($_GET['src']=="signformError") // si cette indication nous informe qu'elle vient du formulalire d'inscription
		{
			switch($_GET['log'])
			{
				case 'loginused':
					$titleModal = "Attention";
					$contentModal = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
					$targetModal = "#signInModal";
				break;
				
				case 'loginshort':
					$titleModal = "Attention";
					$contentModal = "Ce pseudo est trop court, veuillez en choisir un autre.";
					$targetModal = "#signInModal";
				break;
				
				case 'loginshort':
					$titleModal = "Attention";
					$contentModal = "Ce pseudo est trop court, veuillez en choisir un autre.";
					$targetModal = "#signInModal";
				break;
				
				case 'passwordmirror':
					$titleModal = "Attention";
					$contentModal = 'Les mots de passe ne sont pas identiques';
					$targetModal = "#signInModal";
				break;
				
				case 'mailused':
					$titleModal = "Attention";
					$contentModal = 'Cette adresse email est déjà utilisée. Veuillez en renseigner une autre.';
					$targetModal = "#signInModal";
				break;
				
				case 'mailmirror':
					$titleModal = "Attention";
					$contentModal = 'L\'adresse email n\'est pas valide.';
					$targetModal = "#signInModal";
				break;
			}
			
	?>
		<div class="modal modalTemp" tabindex="-1" role="dialog" style="display:block">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title"><?= $titleModal ?></h5>
					<button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target=<?= $targetModal ?>>
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<p class="text-danger"><?= $contentModal ?></p>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-primary closeModal" data-toggle="modal" data-target= <?= $targetModal ?> >Fermer</button>
					</div>
				</div>
			</div>
		</div>	
	<?php
		}
		else if($_GET['src']=="signformSuccess")
		{
			switch ($_GET['log'])
			{
				case ('signed'):
					$titleModal = 'Félicitations';
					$contentModal = 'Bienvenue ' . $_SESSION['login'] . ' ! Vous êtes désormais inscrit sur notre blog et connecté.';
				break;
			}
			//On affiche un message de validation
			//On enregistre le pseudo,le password et le mail dans la session
			//On redirige sur index.php
			
			
	?>
		<div class="modal modalTemp" tabindex="-1" role="dialog" style="display:block">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title"><?= $titleModal ?></h5>
					<button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<p class='text-success'><?= $contentModal ?></p>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-primary closeModal">Fermer</button>
					</div>
				</div>
			</div>
		</div>	
<?php
		}
	}
	else if(isset($_GET['Exception']))
	{
?>
		<div class="modal modalTemp" tabindex="-1" role="dialog" style="display:block">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title">Une erreur est survenue</h5>
					<button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<p class='text-danger'><?= $_GET['Exception'] ?></p>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-primary closeModal" data-toggle="modal" data-target= "#signInModal" >Fermer</button>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>