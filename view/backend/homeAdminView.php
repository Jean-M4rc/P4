<?php $title='Un nouveau récit'; ?>

<?php ob_start(); ?>

	<h1 class="text-center my-3">Un nouveau récit ?</h2>
	<form id="newPostForm" method="post" action="index.php?action=addNewPost">
		<fieldset>
			<div class="form-group-row">
				<h3><label for="postTitle" class="form-label">Titre de votre récit : <input class="form-control" type="text" name="postTitle" size="200px" required></label></h2>
			</div>
			<div class="form-group">
				<textarea id="newPost" name="newPost" cols="80" rows="15"></textarea>
			</div>
			<div class="form-group d-flex justify-content-end">
				<input type="reset" name="reset" class="btn btn-light mr-2" value="Effacer" />
				<input type="submit" name="save" class="btn btn-primary align-right" value="Envoyer ce nouveau récit"/>
			</div>
		</fieldset>
	</form>

<?php $content = ob_get_clean(); ?>
<?php require('view/backend/templateBack.php'); ?>
