<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Un nouveau récit</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link href="public/css/lux.min.css" rel="stylesheet" />
        <link href="public/css/style.css" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src='vendor/Tiny/tinymce/tinymce.min.js'></script>
		<script>
			tinymce.init({
				selector: '#newPost',
				plugins : 'advlist autoresize autolink link image imagetools lists charmap textcolor print preview',
				branding:false,
			});
			tinymce.activeEditor.uploadImages(function(success) {
				$.post('ajax/post.php', tinymce.activeEditor.getContent()).done(function() {
					console.log("Uploaded images and posted content as an ajax request.");
				});
			});
			tinymce.activeEditor.uploadImages(function(success) {
				document.forms[0].submit();
			});


		</script>

    </head>
        
    <body>
	<?php
		include('view/partial/adminNav.php');
	?>
		<!--  ----  Modals ---- -->
		
		<!-- Modal -- logOutModal -->
		<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="LogOutModalCenter" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title" id="exampleModalCenterTitle">Déconnexion</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="http://localhost/P4/index.php?action=logOut"> 
						<fieldset>
							<div class="modal-body">
								<div class="alert alert-danger text-center" role="alert">
								Confirmez votre déconnexion. Vous effacerez aussi vos cookies par cette action. Vous pourrez vous reconnecter ultérieurement. 
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
								<input class="btn btn-primary" id="submit" type="submit" value="Déconnexion">
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<!-- End LogOutModal -->

		
		<?php 
		include('view/partial/modalView.php');
		?>

		<h2 class="text-center my-3">Un nouveau récit ?</h2>
		<form id="newPostForm" method="post" action="">
			<fieldset>
				<div class="form-group">
					<textarea id="newPost" name="newPost" rows="15" cols="80"></textarea>
				</div>
				<div class="form-group d-flex justify-content-end">
					<input type="reset" name="reset" class="btn btn-light mr-2" value="Effacer" />
					<input type="submit" name="save" class="btn btn-primary align-right" value="Envoyer ce nouveau récit"/>
				</div>
			</fieldset>
		</form>
		
		<?php
		include('view/partial/footerBackView.php');
		?>

    </body>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="public/js/validator.js"></script>
	<script src="public/js/anim.js"></script>
</html>