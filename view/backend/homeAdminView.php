<?php
	$title='Administration';
	ob_start();
?>

	<h1 class="text-center my-3">Bienvenue sur l'interface d'administration du blog</h1>
	<div class="jumbotron">
	<img src="public/images/homepage/11_free-photos.jpg" alt="Free-Photos_pixabay.com_caribou_alaska" width="100%"/>
	</div>

<?php
	$content = ob_get_clean();
	require 'view/backend/templateBack.php';
?>
