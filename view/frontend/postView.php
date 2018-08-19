<?php
	$title = $post['title'];
	ob_start();
?>

<h1>Voici mon aventure</h1>
<p class="lead text-center W-100 my-3">Ici vous pouvez lire et commenter mon récit.</p>


<div id="top" class="jumbotron">
	<div class="d-flex m-auto">
<<<<<<< HEAD
	<a href="http://jeanforteroche.code-one.fr/index.php?action=listPosts"><button class="btn btn-secondary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
	<a href="#comments" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-comment-dots fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Voir les commentaires</spann><a/>
=======
		<a href="<?= $GLOBALS['url']; ?>?action=listPosts"><button class="btn btn-outline-primary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
		<a href="#comments" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-comment-dots fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Voir les commentaires</spann><a/>
>>>>>>> poo_transform
	</div>
	<div>
		<h1 class="display-4"><?= $post['title']; ?></h1>
		<p class="lead"><?= $post['content'] ?></p>
		<hr class="my-4">
	</div>
	<div class="d-flex m-auto">
<<<<<<< HEAD
	<a href="http://jeanforteroche.code-one.fr/index.php?action=listPosts"><button class="btn btn-secondary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
	<a href="#top" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-angle-double-up fa-2x"></i><span class="d-none d-md-inline"> - Retour au titre</spann><a/>
=======
		<a href="<?= $GLOBALS['url']; ?>?action=listPosts"><button class="btn btn-outline-primary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
		<a href="#top" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-angle-double-up fa-2x"></i><span class="d-none d-md-inline"> - Retour au titre</spann><a/>
>>>>>>> poo_transform
	</div>

	<div id="comments">
		<h2>Commentaires</h2>

<<<<<<< HEAD
		<form action="http://jeanforteroche.code-one.fr/index.php?action=addComment" method="post">
=======
		<form action="<?= $GLOBALS['url']; ?>?action=addComment" method="post">
>>>>>>> poo_transform
			<div class="form-group">
				<label for="comment">Commentaire :</label><br/>
				<textarea class="form-control" id="comment" name="comment" <?php if(!isset($_SESSION['login'])){ echo "disabled";} ?> required></textarea>
			</div>
			<div class="form-group">
				<input type="hidden" name="postId" value="<?= $post['ID'] ?>"/>
				<input type="hidden" name="autorId" value="<?= $_SESSION['userId'] ?>"/>			
				<button type="submit" class="btn btn-primary" <?php if(!isset($_SESSION['login'])){ echo "disabled";} ?> >Ajouter un commentaire</button>
<?php 
	if(!isset($_SESSION['login'])){
?>
				<div class='help-block text-right text-info '>Vous devez être connecté pour pouvoir commenter <button class="btn btn-primary ml-auto" type="button" data-toggle="modal" data-target="#logInModal"><i class="fas fa-user-check"></i> Connexion</button></div>
<?php
	} 
?> 
			</div>
		</form>
<?php
	while ($comment = $comments->fetch()) {
?>
<<<<<<< HEAD
	<div class="row">
		<div class="media mx-auto col-6 col-sm-8">
		  <div class="d-none d-sm-block"><a href="http://jeanforteroche.code-one.fr/index.php?action=usersList"><img class="align-self-center mr-3" src="<?= $comment['user_avatar']; ?>" alt="Avatar de l'abonné"></a></div>
		  <div class="media-body">
			<h5 class="mt-0"><a href="http://jeanforteroche.code-one.fr/index.php?action=usersList"><?= $comment['user_login'] ?></a> <small class="text-muted">le <?= $comment['date_comment_fr'] ?></small></h5>
			<p class="lead"><?= $comment['comment']; ?></p>
		  </div>
		</div>
		<?php if(isset($_SESSION['login']))
			{
		?>
		<form class="form-group col-6 col-sm-4 text-right" action="http://jeanforteroche.code-one.fr/index.php?action=reportCom" method="post">
			<div class="form-check">
				<input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
				<input type="hidden" name="post_id" value="<?= $post['ID']; ?>"> 
				<input value="1" name="report" type="hidden"><button type="submit" class="btn btn-outline-warning" <?php if ($comment['comment_report']==1){?> disabled><i class=" text-dark fas fa-exclamation-triangle fa-2x align-middle"></i><span class="d-none d-md-inline"><span class="text-dark">Signalé</span> <?php }else{ ?> ><i class="fas fa-exclamation-triangle fa-2x align-middle"></i><span class="d-none d-md-inline"> Signaler <?php } ?></span></button>
=======
		<div class="row">
			<div class="media mx-auto col-6 col-sm-8">
			<div class="d-none d-sm-block"><a href="index.php?action=usersList"><img class="align-self-center mr-3" src="<?= $comment['user_avatar']; ?>" alt="Avatar de l'abonné"></a></div>
			<div class="media-body">
				<h5 class="mt-0"><a href="index.php?action=usersList"><?= $comment['user_login'] ?></a> <small class="text-muted">le <?= $comment['date_comment_fr'] ?></small></h5>
				<p class="lead"><?= $comment['comment']; ?></p>
>>>>>>> poo_transform
			</div>
			</div>
<?php
		if(isset($_SESSION['login'])) {
?>
			<form class="form-group col-6 col-sm-4 text-right" action="<?= $GLOBALS['url']; ?>?action=reportCom" method="post">
				<div class="form-check">
					<input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
					<input type="hidden" name="post_id" value="<?= $post['ID']; ?>"> 
					<input value="1" name="report" type="hidden"><button type="submit" class="btn btn-outline-warning" <?php if ($comment['comment_report']==1){?> disabled><i class=" text-dark fas fa-exclamation-triangle fa-2x align-middle"></i><span class="d-none d-md-inline"><span class="text-dark">Signalé</span> <?php }else{ ?> ><i class="fas fa-exclamation-triangle fa-2x align-middle"></i><span class="d-none d-md-inline"> Signaler <?php } ?></span></button>
				</div>
			</form>
<?php
		}
?>
		</div>	
	<br/>
<?php
	}
?>
	</div>
</div>

<?php
	$content = ob_get_clean();
	require 'templateFront.php';
?>