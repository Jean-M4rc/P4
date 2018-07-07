<?php $title='Les Membres'; ?>

<?php ob_start(); ?>

<h1>Voici Les membres inscrits sur le blog</h1>
<p class="lead text-center">Les membres sont affichés du rang le plus élevé au plus faible et du plus récents au plus anciens.</p>

<div class="container bg-dark my-2">
<div class="row">
<?php
while($data = $users->fetch()){
?>
		<div class="card text-white text-center bg-primary my-3 mx-auto" style="width: 20rem;">
			<div class="card-body">
				<h4 class="card-title"><?= $data['login'] ?></h4>
				<p class="card-text">Mon avatar :</p>
				<p class="card-text"><img class="mx-auto" style="display:block;" src="<?= $data['avatar_path'] ?>" alt="Votre photo de profil"/></p>
				<p class="card-text">Rang : <?php if($data['admin']==0){echo'Abonné(e)';}elseif($data['admin']==1){echo'Modérateur';}elseif($data['admin']==2){echo 'Administrateur';}else{echo'indéfini, contactez-moi au plus vite ^^';}?></p>
				<p class="card-text">Pays : <?= $data['country'] ?></p>
				<p class="card-text">Compte créé le <?= $data['date_sign_fr'] ?></p>
				<p class="card-text">Nombre de commentaires postés : <span class="badge badge-pill badge-light"><?= $data['commentsUser'] ?></span></p>
			</div>
		</div>

<?php
}
$users->closeCursor();
?>
</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>