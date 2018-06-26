<?php $title = $post['title']; ?>
<?php ob_start(); ?>

<h1>Voici mon aventure</h1>
<p class="lead text-center W-100 my-3">Ici vous pouvez lire et commenter mon récit.</p>


<div id="top" class="jumbotron">
	<div class="d-flex m-auto">
	<a href="index.php?action=listPosts"><button class="btn btn-secondary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
	<a href="#comments" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-comment-dots fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Voir les commentaires</spann><a/>
	</div>
	<div>
	<h1 class="display-4"><?= $post['title']; ?></h1>
	<p class="lead"><?= $post['content'] ?></p>
	<hr class="my-4">
	</div>
	<div class="d-flex m-auto">
	<a href="index.php?action=listPosts"><button class="btn btn-secondary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
	<a href="#top" class="btn btn-primary btn-lg ml-auto"><i class="fas fa-angle-double-up fa-2x"></i><span class="d-none d-md-inline"> - Retour au titre</spann><a/>
	</div>

	<div id="comments">
		<h2>Commentaires</h2>

		<form action="index.php?action=addComment" method="post">
			<div class="form-group">
				<label for="comment">Commentaire :</label><br/>
				<textarea class="form-control" id="comment" name="comment" <?php if(!isset($_SESSION['login'])){ echo "disabled";} ?> required></textarea>
			</div>
			<div class="form-group">
				<input type="hidden" name="postId" value="<?= $post['ID'] ?>"/>
				<input type="hidden" name="autorId" value="<?= $_SESSION['userId'] ?>"/>			
				<button type="submit" class="btn btn-primary" <?php if(!isset($_SESSION['login'])){ echo "disabled";} ?> >Ajouter un commentaire</button>
				<?php if(!isset($_SESSION['login']))
				{
					?>
					<div class='help-block text-right'>Vous devez être connecté pour pouvoir commenter --> <button class="btn btn-primary ml-auto" type="button" data-toggle="modal" data-target="#logInModal"><i class="fas fa-user-check"></i> Connexion</button></div>
				<?php
				} 
				?> 
			</div>
		</form>

<?php
while ($comment = $comments->fetch())
{
?>
	<div class="media mx-auto">
	  <img class="align-self-center mr-3" src="<?= $comment['user_avatar']; ?>" alt="Avatar de l'abonné">
	  <div class="media-body">
		<h5 class="mt-0"><?= $comment['user_login'] ?> <small class="text-muted">le <?= $comment['date_comment_fr'] ?></small></h5>
		<p class="lead"><?= $comment['comment']; ?></p>
	  </div>
	</div>
<?php
}
?>
	</div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>