<?php $title='Mes aventures'; ?>

<?php ob_start(); ?>

<h1>Voici mes dernières aventures</h1>
<p class="lead text-center W-100 my-3">Ici vous trouverez un extrait de mes dernières aventures, vous pouvez lire l'aventure en entier en cliquant sur le bouton "Lire l'aventure"</p>

<div class="container bg-dark my-2">
<div class="row">
<?php
while($data = $posts->fetch()){
?>
		<div class="card border-primary d-inline-block align-top mx-auto my-2" style="width:21rem;">
			<div class="card-header">Ajouté le <?= $data['date_create_fr']; ?></div>
			<div class="card-body">
				<h4 class="card-title"><?= $data['title']; ?></h4>
				<p class="card-text"><?= $data['resume'] ?></p>
			</div>
			<div class="card-footer text-center">
				<a href="index.php?action=post&id=<?= $data['ID'] ?>"><button class="btn btn-primary btn-lg"><i class="fas fa-book-open fa-2x align-middle"></i><span class="d-none d-sm-inline"> - Lire cette aventure</span></button></a>
			</div>
		</div>

<?php
}
$posts->closeCursor();
?>
</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>