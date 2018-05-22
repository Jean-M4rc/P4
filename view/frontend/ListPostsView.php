<?php $title='Mes aventures'; ?>

<?php ob_start(); ?>
<h1>Voici mes dernières aventures</h1>
<p class="lead pintro">Ici vous trouverez un extrait de mes dernières aventures, vous pouvez lire l'aventure en entier en cliquant sur le bouton "Lire l'aventure"</p>

<?php

while($data = $posts->fetch()){
?>
	<div class="jumbotron">
		<h3 class="display-7"><?= htmlspecialchars($data['title']) ?></h1>
		<p class="lead">le <?= $data['date_create_fr'] ?></p>
		<hr class="my-4">
		<p><?= nl2br(htmlspecialchars($data['content'])) ?></p>
		<p class="lead">
			<a class="btn btn-primary btn-lg" href="index.php?action=post&amp;id=<?= $data['id'] ?>" role="button">Lire cette aventure</a>
		</p>
	</div>
<?php
}
$posts->closeCursor();
?>
<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>