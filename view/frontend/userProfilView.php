<?php $title='Mon profil'; ?>

<?php ob_start(); ?>

	<h1>Mes informations</h1>
	<p class="lead pintro">Ici vous trouverez les informations de votre profil. Vous pouvez les modifier ou les corriger.</p>
<!-- on va utiliser les $_SESSION ici -->
	<div class="jumbotron">
		<h3 class="display-7"><?= htmlspecialchars($data['title']) ?></h1>
		<p class="lead">le <?= $data['date_create_fr'] ?></p>
		<hr class="my-4">
		<p><?= nl2br(htmlspecialchars($data['content'])) ?></p>
		<p class="lead">
			<a class="btn btn-primary btn-lg" href="index.php?action=post&amp;id=<?= $data['id'] ?>" role="button">Lire cette aventure</a>
		</p>
	</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>