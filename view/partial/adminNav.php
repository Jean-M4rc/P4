<nav class="navbar navbar-expand-xl navbar-light bg-light">
	<a class="navbar-brand" href="<?= $GLOBALS['url']; ?>">Jérôme Forteroche | <i class="fas fa-home"></i></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="true" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse justify-content-end" id="navbarColor03">

		<div class="btngroup">
			<a href='<?= $GLOBALS['url']; ?>?action=pandOra&target=commentsEdit'><button class="btn btn-outline-warning mr-1 my-1" type="button"><i class="fas fa-quote-right"></i> Commentaires</button></a>
<?php
	if ($_SESSION['rule'] == 2)
	{
?>
			<a href='<?= $GLOBALS['url']; ?>?action=pandOra&target=postCreate'><button class="btn btn-outline-primary mr-1 my-1" type="button"><i class="far fa-file-alt"></i> Ecrire</button></a>
			<a href='<?= $GLOBALS['url']; ?>?action=pandOra&target=postsEdit'><button class="btn btn-outline-success mr-1 my-1" type="button"><i class="fas fa-book"></i> Récits</button></a>
			<a href='<?= $GLOBALS['url']; ?>?action=pandOra&target=usersEdit'><button class="btn btn-outline-info mr-1 my-1" type="button"><i class="fas fa-users"></i> Abonnés</button></a>
<?php
	}
?>
			<button class="btn btn btn-outline-danger my-1" type="button" data-toggle="modal" data-target="#logOutModal"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
		</div>
	</div>
</nav>
		