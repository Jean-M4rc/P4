<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link href="public/css/lux.min.css" rel="stylesheet" />
        <link href="public/css/style.css" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src='vendor/Tiny/tinymce/tinymce.min.js'></script>
		<!-- Caractéristiques du WYSIWYG -->
		<script>
			tinymce.init({
				selector: 'textarea',
				themes:'inlite',
				height:300,
				plugins : 'preview hr',
				menu: {
					edit: {title: 'Edit', items: 'cut copy paste pastetext | selectall'},
					insert: {title: 'Insert', items: ' template hr'},
					view: {title: 'Aperçu', items: 'preview'}
				},
				toolbar:'undo redo | bold italic underline | fontselect | fontsizeselect | formatselect | alignleft aligncenter alignright alignjustify | indent outdent',
				statusbar : false,
				branding:false,
				language :'fr_FR'
			})
		</script>
    </head>
    <body>

<?php
	include('view/partial/adminNav.php');
<<<<<<< HEAD
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
					<form method="post" action="http://jeanforteroche.code-one.fr/index.php?action=logOut"> 
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
=======
?>
	
	<!-- Modal logOutModal -->
	<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="LogOutModalCenter" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalCenterTitle">Déconnexion</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
>>>>>>> poo_transform
				</div>
				<form method="post" action="<?= $GLOBALS['url'] ?>?action=logOut"> 
					<fieldset>
						<div class="modal-body">
							<div class="alert alert-danger text-center" role="alert">
							Confirmez votre déconnexion. Vous effacerez aussi vos cookies par cette action. Vous pourrez vous reconnecter ultérieurement. 
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Annuler</button>
							<input class="btn btn-primary" id="submit" type="submit" value="Déconnexion">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<!-- End LogOutModal -->

<?php 
	include('helper/modalindex.php');
	echo $content;
	include('view/partial/footerBackView.php');
?>

    </body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="public/js/anim.js"></script>
	<script src="public/js/validator.js"></script>
</html>