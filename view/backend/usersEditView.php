<?php
	$title='Gérer vos abonnés';
	ob_start();
?>

<div class="container">
	<h1 class="text-center">Voici l'ensemble de vos abonnés :</h1>
	<p class="text-center">Classer du plus récent au plus ancien</p>

	<table class="table table-striped mw-70">
		<thead class="thead-dark">
			<tr class="text-center">
				<th class="align-middle"scope="col">Pseudo de l'abonné</th>			
				<th class="d-none d-lg-table-cell align-middle" scope="col">Toutes les informations de l'abonné</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Modifier le rang</th>
				<th class="d-none d-lg-table-cell align-middle" scope="col">Bannissement</th>
				<th class="d-table-cell d-lg-none align-middle" scope="col" style="width:140px">Actions</th>
			</tr>
		</thead>
		<tbody>

<?php
    while ($data = $users->fetch()) {
?>
			<tr class="text-dark text-center">
				<td class="align-middle"><?= htmlspecialchars($data['login'])?></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#infoModal<?= $data['userID'] ?>"><i class="far fa-address-card"></i> Voir les infos</span></button></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#upgradeModal<?= $data['userID'] ?>"><i class="fas fa-arrows-alt-v"></i> Modifier</button></td>
				<td class="d-none d-lg-table-cell align-middle"><button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#banModal<?= $data['userID'] ?>"><?php if($data['ban']==0){echo'<i class="fas fa-times-circle"></i> Bannir';}elseif($data['ban']==1){echo'<i class="far fa-check-circle"></i> Lever le bannissement';}else{echo'Le ban est mal défini';}?></button></td>
				
				<!-- partie caché en vue large -->
				<td class="d-table-cell d-lg-none">
					<button class="btn btn-outline-success action-toggler mb-1" type="button" data-toggle="collapse" data-target="#actionCollapsed<?= $data['userID'] ?>" aria-controls="actionCollapsed" aria-expanded="false"><i class="fas fa-bars"></i></button>
					<div id="actionCollapsed<?= $data['userID'] ?>" class="collapse px-0" style="width:90px">
						<button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#infoModal<?= $data['userID'] ?>"><i class="far fa-address-card"></i></span></button>
						<button class="btn btn-outline-primary my-1" type="button" data-toggle="modal" data-target="#upgradeModal<?= $data['userID'] ?>"><i class="fas fa-arrows-alt-v"></i></button>
						<button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#banModal<?= $data['userID'] ?>"><?php if($data['ban']==0){echo'<i class="fas fa-times-circle"></i>';}elseif($data['ban']==1){echo'<i class="far fa-check-circle"></i>';}else{echo'Erreur';}?></button>
					</div>
				</td>
			</tr>

<<<<<<< HEAD
	<!-- Modal -- infoModal -->
	<div class="modal fade" id="infoModal<?= $data['userID'] ?>" tabindex="-1" role="dialog" aria-labelledby="infoModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Informations de l'abonné</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				<p class="lead">
					Pseudo : <span class="text-success"><?= $data['login'];?></span><br/><br/>
					Inscrit depuis le : <span class="text-dark"><?= $data['date_sign_fr'];?></span><br/><br/>
					Adresse Mail : <span class="text-info"><?= $data['email'];?></span><br/><br/>
					Rang : <span class="text-warning"><?php if($data['admin']==0){echo'Abonné(e)';}elseif($data['admin']==1){echo'Modérateur';}elseif($data['admin']==2){echo 'Administrateur';}else{echo'indéfini, contactez-moi au plus vite ^^';}?></span><br/><br/>
					Nombre de commentaire postés : <span class="text-dark"><?= $data['commentsUser'];?></span><br/><br/>			
				</p>
				<div class="modal-body text-center">
					<img src="<?= $data['avatar_path']; ?>" alt="avatar de l'abonné" width="30%">
				</div>
				</div>
				<div class="modal-footer">
					<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=initAvatar">
						<input type="hidden" value="<?= $data['userID']; ?>" name="userID"/>
						<button type="submit" class="btn btn-outline-primary"><i class="fas fa-redo-alt"></i><span class="d-none d-sm-inline"> Réinitiliser l'avatar</span></button>
					</form>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End infoModal -->
		
	<!-- Modal -- upgradeModal -->
	<div class="modal fade" id="upgradeModal<?= $data['userID'] ?>" tabindex="-1" role="dialog" aria-labelledby="upgradeModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Modifier le rang de l'abonné</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=upgradeUser"> 
					<fieldset>
=======
			<!-- infoModal -->
			<div class="modal fade" id="infoModal<?= $data['userID'] ?>" tabindex="-1" role="dialog" aria-labelledby="infoModalCenter" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalCenterTitle">Informations de l'abonné</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
>>>>>>> poo_transform
						<div class="modal-body">
						<p class="lead">
							Pseudo : <span class="text-success"><?= $data['login'];?></span><br/><br/>
							Inscrit depuis le : <span class="text-dark"><?= $data['date_sign_fr'];?></span><br/><br/>
							Adresse Mail : <span class="text-info"><?= $data['email'];?></span><br/><br/>
							Rang : <span class="text-warning"><?php if($data['admin']==0){echo'Abonné(e)';}elseif($data['admin']==1){echo'Modérateur';}elseif($data['admin']==2){echo 'Administrateur';}else{echo'indéfini, contactez-moi au plus vite ^^';}?></span><br/><br/>
							Nombre de commentaire postés : <span class="text-dark"><?= $data['commentsUser'];?></span><br/><br/>			
						</p>
						<div class="modal-body text-center">
							<img src="<?= $data['avatar_path']; ?>" alt="avatar de l'abonné" width="30%">
						</div>
						</div>
						<div class="modal-footer">
							<form method="post" action="<?= $GLOBALS['url'] ?>?action=pandOra&target=initAvatar">
								<input type="hidden" value="<?= $data['userID']; ?>" name="userID"/>
								<button type="submit" class="btn btn-outline-primary"><i class="fas fa-redo-alt"></i><span class="d-none d-sm-inline"> Réinitiliser l'avatar</span></button>
							</form>
							<button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End infoModal -->
				
			<!-- upgradeModal -->
			<div class="modal fade" id="upgradeModal<?= $data['userID'] ?>" tabindex="-1" role="dialog" aria-labelledby="upgradeModalCenter" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalCenterTitle">Modifier le rang de l'abonné</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" action="<?= $GLOBALS['url'] ?>?action=pandOra&target=upgradeUser"> 
							<fieldset>
								<div class="modal-body">
									<p class="lead">L'abonné <span class="text-success"><?= $data['login']; ?></span> possède le rang <span class="text-info"><?php if($data['admin']==0){echo'Abonné';}elseif($data['admin']==1){echo'Modérateur';}elseif($data['admin']==2){echo 'Administarteur';}else{echo'indéfini, contactez-moi au plus vite ^^';}?></span></p><br/>
									<p class="lead"> Définir les nouvelles permissions :</p>
									<div class="mx-auto">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="admin" id="inlineRadio1<?= $data['userID'] ?>" value="0"  <?php if($data['admin'] ==0){echo'checked=""';}?>>
											<label class="form-check-label text-info" for="inlineRadio1<?= $data['userID'] ?>">Abonné</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="admin" id="inlineRadio2<?= $data['userID'] ?>" value="1"  <?php if($data['admin'] ==1){echo'checked=""';}?>>
											<label class="form-check-label text-success" for="inlineRadio2<?= $data['userID'] ?>">Modérateur</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="admin" id="inlineRadio3<?= $data['userID'] ?>" value="2"  <?php if($data['admin'] ==2){echo'checked=""';}?>>
											<label class="form-check-label text-danger" for="inlineRadio3<?= $data['userID'] ?>">Administrateur</label>
										</div>
									</div><br/>
									<p class="alert-info">Le rang "Abonné" permet de signaler et de commenter les récits.<br/>Le rang "Modérateur" permet d'accéder à la modération des commentaires.<br/>Le rang "Administrateur" permet d'accéder à l'ensemble des outils d'administrations du blog.</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="userID" value="<?= $data['userID']; ?>">
									<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
									<button type="submit" class="btn btn-primary"><span class="d-none d-sm-inline">Appliquer les modifications</span><span class="d-inline d-sm-none">Valider</span></button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
<<<<<<< HEAD
				<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=pandOra&target=banUser"> 
					<fieldset>
						<div class="modal-body">
							<div class="alert alert-danger text-center font-weight-bold lead" role="alert">
							Etes-vous sûr de vouloir <?php if($data['ban']==0){echo'bannir';}elseif($data['ban']==1){echo'autoriser';}else{echo'Erreur';}?> cet utilisateur ? 
							</div>
							<div class="card mx-auto text-white bg-primary mb-3" style="width: 18rem;">
								<div class="card-body">
									<h5 class="card-title"><?= $data['login']; ?></h5>
									<p class="card-text">Inscrit depuis le <?= $data['date_sign_fr']; ?></p>
=======
			</div>
			<!-- End upgradeModal -->
			
			<!-- banModal -->
			<div class="modal fade" id="banModal<?= $data['userID'] ?>" tabindex="-1" role="dialog" aria-labelledby="banModalCenter" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalCenterTitle">Banissement</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" action="<?= $GLOBALS['url'] ?>?action=pandOra&target=banUser"> 
							<fieldset>
								<div class="modal-body">
									<div class="alert alert-danger text-center font-weight-bold lead" role="alert">
									Etes-vous sûr de vouloir <?php if($data['ban']==0){echo'bannir';}elseif($data['ban']==1){echo'autoriser';}else{echo'Erreur';}?> cet utilisateur ? 
									</div>
									<div class="card mx-auto text-white bg-primary mb-3" style="width: 18rem;">
										<div class="card-body">
											<h5 class="card-title"><?= $data['login']; ?></h5>
											<p class="card-text">Inscrit depuis le <?= $data['date_sign_fr']; ?></p>
										</div>
									</div>
								</div>
								<div class="modal-footer d-block">
									<div class="text-right">
										<input type="hidden" name="userID" value="<?= $data['userID']; ?>"/>
										<input type="hidden" name="admin" value="<?= $data['admin']; ?>"/>
										<input type="hidden" name="ban" value="<?= $data['ban']; ?>"/>
										<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
										<button class="btn btn-primary" type="submit" <?php if($data['admin']==2){echo'disabled';}?>><?php if($data['ban']==0){echo'bannir';}elseif($data['ban']==1){echo'autoriser';}else{echo'Erreur';}?></button>
									</div>
									<div>							
									<?php if($data['admin']==2){echo'<br/><p class="alert alert-danger text-center font-weight-bold" role="alert">
									Vous ne pouvez pas bannir un administrateur, rétrogradez-le avant.</p>';}?>
									</div>
>>>>>>> poo_transform
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
$users ->closeCursor();
$content = ob_get_clean();
require('view/backend/templateBack.php');
?>