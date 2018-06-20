<?php $title = $post['title']; ?>
<?php ob_start(); ?>

<h1>Voici mon aventure</h1>
<p class="lead text-center W-100 my-3">Ici vous pouvez lire et commenter mon récit.</p>

<div class="jumbotron">
	<h1 class="display-4"><?= $post['title']; ?></h1>
	<p class="lead"><?= $post['content'] ?></p>
	<hr class="my-4">
	<div class="d-flex m-auto">
	<a href="index.php?action=listPosts"><button class="btn btn-secondary btn-lg"><i class="fas fa-chevron-circle-left fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Retour aux récits</span></button></a>
	<button class="btn btn-primary btn-lg ml-auto"  data-toggle="collapse" data-target="#collapseComment" aria-expanded="false" aria-controls="collapseComments"><i class="fas fa-comment-dots fa-2x  align-middle"></i><span class="d-none d-md-inline"> - Voir les commentaires</spann></button>
	</div>
</div>

<div id="collapseComment" class="jumbotron collapse">
<h2>Commentaires</h2>

<form action="" method="post">
	<div>
		<label for="comment">Commentaire :</label><br/>
		<textarea id="comment" name="comment"></textarea>
	</div>
	<div class="form-group">
		<input type="submit" <?php if(!isset($_SESSION['login'])){ echo "disabled";} ?> value="Ajouter un commentaire"/>
		<?php if(!isset($_SESSION['login']))
		{
			echo "<div class='help-block'>Vous devez être connecté pour pouvoir commenter</div>";
		} 
		?> 
	</div>
</form>

<?php
/*
while ($comment = $comments->fetch())
{
?>
	<p><strong><?= htmlspecialchars($comment['author_id']) ?></strong> le <?= $comment['date_comment_fr'] ?> (<a href="index.php?action=getComment&amp;commentId=<?= $comment['id'] ?>">Modifier</a>)</p>
	<p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
}
*/?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>