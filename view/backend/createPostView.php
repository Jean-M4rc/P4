<?php
	$title = 'Un nouveau récit'; 
	ob_start();
?>

	<h1 class="text-center my-3">Un nouveau récit ?</h1>
	<form id="newPostForm" method="post" action="<?= $GLOBALS['url'] ?>?action=addNewPost" data-toggle="validator" role="form">
		<fieldset>

			<div class="form-group-row mb-3">
				<label for="postTitle" class="form-label">
					<h3>Titre de votre récit :</h3>
					<input class="form-control" type="text" data-minlength="5" name="postTitle" size="200px" required>
					<div class="help-block">Minimum 5 lettres</div>
				</label>
			</div>

			<div class="form-group">
				<textarea id="newPost" name="newPost" cols="80" rows="15"></textarea>
			</div>

			<div class="form-group d-flex justify-content-end">
				<input type="reset" name="reset" class="btn btn-outline-primary mr-2" value="Effacer" />
				<input type="submit" name="save" class="btn btn-primary align-right" value="Envoyer ce nouveau récit"/>
			</div>
			
		</fieldset>
	</form>

<?php
	$content = ob_get_clean();
	require 'view/backend/templateBack.php';
?>
