<?php $title='Mes aventures'; ?>

<?php ob_start(); ?>

<h1>Voici mes dernières aventures</h1>
<p class="lead pintro">Ici vous trouverez un extrait de mes dernières aventures, vous pouvez lire l'aventure en entier en cliquant sur le bouton "Lire l'aventure"</p>

<div class="d-flex">
<?php
while($data = $posts->fetch()){
?>
		<div class="card border-primary justify-content-around" style="width: 22rem;height:25rem;">
			<div class="card-header">Ajouté le <?= $data['date_create_fr'] ?></div>
			<div class="card-body">
				<h4 class="card-title"><?= $data['title'] ?></h4>
				<p class="card-text"><?= nl2br($data['resume']) ?></p>
			</div>
			<div class="card-footer">
				<a class="btn btn-primary btn-lg" href="index.php?action=post&id=<?= $data['id'] ?>" role="button">Lire cette aventure</a>
			</div>
		</div>

<?php
}
$posts->closeCursor();
?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>