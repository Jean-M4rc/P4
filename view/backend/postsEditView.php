<?php $title='Gérer vos récits'; ?>

<?php ob_start(); ?>

<div class="w-90 m-auto">
	<h1 class="text-center">Voici l'ensemble de vos récits :</h1>
	<p class="text-center">Classer du plus récent au plus ancien</p>

	<table class="table table-striped w-100">
		<thead class="thead-dark">
			<tr class="text-center">
				<!--<th class="d-none d-sm-table-cell align-middle" scope="col">Numéro de récit</th>-->
				<th class="align-middle"scope="col">Titre du récit</th>
				<th class="d-none d-sm-table-cell align-middle" scope="col">Date de création du récit</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Voir le récit</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Modifier le récit</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Supprimer le récit</th>
				<th class="d-table-cell d-lg-none align-middle" scope="col" style="width:140px">Actions</th> <!-- lui doit etre caché en vue large -->
			</tr>
		</thead>
		<tbody>

<?php
    while ($data = $posts->fetch())
    {
?>
			<tr class="text-dark text-center">
				<!--<td class="d-none d-sm-table-cell align-middle"><?= htmlspecialchars($data['ID'])?></td>-->
				<td class="align-middle"><?= htmlspecialchars($data['title'])?></td>
				<td class="d-none d-sm-table-cell align-middle">Le <?= htmlspecialchars($data['date_create_fr'])?></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#lookModal<?= $data['ID'] ?>"><i class="fas fa-search-plus"></i> Plus d'infos</button></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#updateModal<?= $data['ID'] ?>"><i class="fas fa-edit"></i> Modifier</button></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#deleteModal<?= $data['ID'] ?>"><i class="far fa-trash-alt"></i> Supprimer</button></td>
				
				<!-- partie caché en vue large -->
				<td class="d-table-cell d-lg-none">
					<button class="btn btn-outline-success action-toggler mb-1" type="button" data-toggle="collapse" data-target="#actionCollapsed<?= $data['ID'] ?>" aria-controls="actionCollapsed" aria-expanded="false"><i class="fas fa-bars"></i></button>
					<div id="actionCollapsed<?= $data['ID'] ?>" class="collapse px-0" style="width:90px">
						<button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#lookModal<?= $data['ID'] ?>"><i class="fas fa-search-plus"></i></button>
						<button class="btn btn-outline-primary my-1" type="button" data-toggle="modal" data-target="#updateModal<?= $data['ID'] ?>"><i class="fas fa-edit"></i></button>
						<button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#deleteModal<?= $data['ID'] ?>"><i class="far fa-trash-alt"></i></button>
					</div>
				</td>
			</tr>			
	<!--  ----  Modals ---- -->
	
	<!-- Modal -- lookModal -->
	<div class="modal fade" id="lookModal<?= $data['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="LookModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle"><?= htmlspecialchars($data['title']) ?></h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				<?= $data['content'] ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End LookModal -->
	
	<!-- Modal -- updateModal -->
	<div class="modal fade" id="updateModal<?= $data['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Corriger quelque chose ?</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=updatePost"> 
					<fieldset>
						<div class="modal-body">
							<div class="form-group">
								<label for="postTitle">Le titre de votre récit</label>
								<input type="text" class="form-control" name="postTitle" value="<?= $data['title']; ?>"/>
							</div>
							<div class="form-group">
								<label for="postContent">Le contenu de votre récit</label>
								<textarea name="postContent" cols="80" rows="20"><?= $data['content'] ?></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="postID" value="<?= $data['ID']; ?>">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
							<input class="btn btn-primary" id="submit" type="submit" value="Modifier">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<!-- End LookModal -->
	
	<!-- Modal -- deleteModal -->
	<div class="modal fade" id="deleteModal<?= $data['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Suppression</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=deletePost"> 
					<fieldset>
						<div class="modal-body">
							<div class="alert alert-danger text-center font-weight-bold" role="alert">
							Etes-vous sûr de vouloir supprimer ce récit ? 
							</div>
							<div class="card mx-auto text-white bg-primary mb-3" style="width: 18rem;">
								<div class="card-body">
									<h5 class="card-title"><?= $data['title']; ?></h5>
									<p class="card-text"><?= $data['resume']; ?></p>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						<input type="hidden" name="postID" value="<?= $data['ID']; ?>"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
							<input class="btn btn-primary" id="submit" type="submit" value="Supprimer">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<!-- End LookModal -->
	
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