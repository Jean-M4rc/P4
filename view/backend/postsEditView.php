<?php $title='Gérer vos récits'; ?>

<?php ob_start(); ?>

<div class="w-90 m-auto">
	<h1 class="text-center">Voici l'ensemble de vos récits :</h1>
	<p class="text-center">Classer du plus récent au plus ancien</p>

	<table class="table table-striped table-sm m-auto">
		<thead class="thead-dark">
			<tr>
				<th class="align-middle text-center" scope="col">Numéro de récit</th>
				<th class="align-middle text-center" scope="col">Titre du récit</th>
				<th class="align-middle text-center" scope="col">Date de création du récit</th>
				<th class="align-middle text-center" scope="col">Voir le récit</th>
				<th class="align-middle text-center" scope="col">Modifier le récit</th>
				<th class="align-middle text-center" scope="col">Supprimer le récit</th>
				<th class="align-middle text-center d-table-cell d-lg-none" scope="col">Actions</th> <!-- lui doit etre caché en vue large -->
			</tr>
		</thead>
		<tbody>

<?php
    while ($data = $posts->fetch())
    {
?>
			<tr class="text-dark">
				<td><?= htmlspecialchars($data['ID'])?></td>
				<td><?= htmlspecialchars($data['title'])?></td>
				<td><?= htmlspecialchars($data['date_create_fr'])?></td>
				<td><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#lookModal"><i class="fas fa-search-plus"></i> Plus d'infos</button></td>
				<td><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#lookModal"><i class="fas fa-search-plus"></i> Modifier</button></td>
				<td><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#lookModal"><i class="fas fa-search-plus"></i> Supprimer</button></td>
				
				<!-- partie caché en vue large -->
				<td class="d-table-cell d-lg-none"><button class="btn btn-outline-primary action-toggler" type="button" data-toggle="collapse" data-target="#actionCollapsed" aria-controls="actionCollapsed" aria-expanded="true" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button></td>
			</tr>
	<!--  ----  Modals ---- -->
	<!-- Modal -- logOutModal -->
	<div class="modal fade" id="lookModal" tabindex="-1" role="dialog" aria-labelledby="LogOutModalCenter" aria-hidden="true">
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
							Confirmez votre déconnexion. Vous effacerez aussi vos cookies par cette action. Vous pourrez vous reconnecter ultérieurement. 
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
	
<?php
    }
?>
		</tbody>
	</table>
</div>
<?php
	$posts ->closeCursor(); // Termine le traitement de la requête
?>
<?php $content = ob_get_clean(); ?>
<?php require('view/backend/templateBack.php'); ?>