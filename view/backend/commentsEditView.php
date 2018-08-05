<?php $title='Administration des commentaires'; ?>

<?php ob_start(); ?>
<div class="w-90 m-auto">
	<h1 class="text-center">Voici l'ensemble des commentaires :</h1>
	<p class="text-center">Les commentaires signalés apparaissent en premiers et de manière antéchronologique.</p>

	<table class="table table-striped w-100">
		<thead class="thead-dark">
			<tr class="text-center">
				<th class="d-none d-sm-table-cell align-middle"scope="col">Auteur</th>
				<th class="d-none d-xl-table-cell align-middle" scope="col">Date</th>
				<th class="d-none d-sm-table-cell align-middle" scope="col">Titre du récit</th>
				<th class="align-middle" scope="col">Commentaire</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Signalement</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Modérer / Démodérer</th>	
				<th class="d-none d-lg-table-cell align-middle" scope="col">Suppression</th>
				<th class="d-table-cell d-lg-none align-middle" scope="col" style="width:140px">Actions</th>
			</tr>
		</thead>
		<tbody>
		
<?php
    while ($data = $com->fetch())
    {
?>
			<tr class="text-dark text-center">
				<td class="d-none d-sm-table-cell align-middle"><?= $data['user_login']?></td>
				<td class="d-none d-xl-table-cell align-middle">Le <?= $data['date_comment_fr']?></td>
				<td class="d-none d-sm-table-cell align-middle">Le <?= $data['post_title']?></td>
				<td class="align-middle"><?= $data['comment']?></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-warning" type="button" data-toggle="modal" data-target="#reportModal<?= $data['comment_id'] ?>" ><?php if ($data['comment_report']==0){ echo '<i class="fas fa-exclamation-circle"></i><span class="d-none d-xl-inline"> Signaler'; }else{echo '<i class="far fa-check-circle"></i><span class="d-none d-xl-inline"> Lever le signalement';}?></span></button></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#moderateModal<?= $data['comment_id'] ?>"><?php if ($data['comment_moderation']==0){ echo '<i class="fas fa-comment-slash"></i></i><span class="d-none d-xl-inline"> Modérer'; }else{echo '<i class="fas fa-comment"></i><span class="d-none d-xl-inline"> Lever la modération';}?></span></button></td>				
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#deleteModal<?= $data['comment_id'] ?>"><i class="far fa-trash-alt"></i> <span class="d-none d-xl-inline">Supprimer</span></button></td>
				
				<!-- partie caché en vue large -->
				<td class="d-table-cell d-lg-none">
					<button class="btn btn-outline-success action-toggler mb-1" type="button" data-toggle="collapse" data-target="#actionCollapsed<?= $data['comment_id'] ?>" aria-controls="actionCollapsed" aria-expanded="false"><i class="fas fa-bars"></i></button>
					<div id="actionCollapsed<?= $data['comment_id'] ?>" class="collapse px-0" style="width:90px">
						<button class="btn btn-outline-warning" type="button" data-toggle="modal" data-target="#reportModal<?= $data['comment_id'] ?>"><?php if ($data['comment_report']==0){ echo '<i class="fas fa-exclamation-circle"></i>';}else{echo '<i class="far fa-check-circle"></i>';}?></button>
						<button class="btn btn-outline-primary my-1" type="button" data-toggle="modal" data-target="#moderateModal<?= $data['comment_id'] ?>"><?php if ($data['comment_moderation']==0){ echo '<i class="fas fa-comment-slash"></i>'; }else{echo '<i class="fas fa-comment"></i>';}?></button>
						<button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#deleteModal<?= $data['comment_id'] ?>"><i class="far fa-trash-alt"></i></button>
					</div>
				</td>
			</tr>			
	
	<!-- reportModal -->
	<div class="modal fade" id="reportModal<?= $data['comment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="reportModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle"><?php if ($data['comment_report']==0){ echo "Signaler le commentaire";} else { echo "Lever le signalement";} ?></h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="lead">Auteur : <?= $data['user_login']; ?></p>
					<p>Commentaire : <?= $data['comment']; ?></p>
				</div>
				<div class="modal-footer">
					<form method="post" action="index.php?action=pandOra&target=reportComment">
						<input type="hidden" name="comment_id" value="<?= $data['comment_id'] ?>">
						<input type="hidden"  name="comment_report" value="<?= $data['comment_report']; ?>">
						<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary">Confirmer</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End reportModal -->
	
	<!-- moderateModal -->
	<div class="modal fade" id="moderateModal<?= $data['comment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle"><?php if ($data['comment_moderation']==0){ echo "Modérer le commentaire";} else { echo "Lever la modération";} ?></h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="lead">Auteur : <?= $data['user_login']; ?></p>
					<p>Commentaire : <?= $data['comment']; ?></p>
				</div>
				<div class="modal-footer">
					<form method="post" action="index.php?action=pandOra&target=moderationCom">
						<input type="hidden" name="comment_id" value="<?= $data['comment_id'] ?>">
						<input type="hidden"  name="comment_moderation" value="<?= $data['comment_moderation']; ?>">
						<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-primary">Confirmer</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- End moderateModal -->
	
	<!-- deleteModal -->
	<div class="modal fade" id="deleteModal<?= $data['comment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Suppression</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="index.php?action=pandOra&target=deleteCom"> 
					<fieldset>
						<div class="modal-body">
							<div class="alert alert-danger text-center font-weight-bold" role="alert">
							Etes-vous sûr de vouloir supprimer ce commentaire ? 
							</div>
							<div class="card mx-auto text-white bg-primary mb-3" style="width: 18rem;">
								<div class="card-body">
									<h5 class="card-title">Auteur : <?= $data['user_login']?></h5>
									<p class="card-text">Commentaire : <?= $data['comment']; ?></p>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="comment_id" value="<?= $data['comment_id'] ?>">
							<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
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
	$com->closeCursor(); // Termine le traitement de la requête
?>
<?php $content = ob_get_clean(); ?>
<?php require('view/backend/templateBack.php'); ?>