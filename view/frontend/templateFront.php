<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
		<link href="../../public/css/lux.min.css" rel="stylesheet" />
        <link href="../../public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Jérôme Forteroche</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Mes billets</a>
      </li>
	<?php
		if (isset($_SESSION['pseudo'])||isset($_COOKIE['pseudo'])){
	?>
			<li class="nav-item">
				<a class="nav-link" href="#"><i class="fas fa-user"></i> Mon profil</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
			</li>
		</ul>
	<?php
		} else {
	?>
			<li class="nav-item">
				<a class="nav-link" href="#">Inscription</a>
			</li>
			<form class="form-inline my-2 my-lg-0" method="post" action="#">
				<input class="form-control mr-sm-2" placeholder="Login" name="login" type="text">
				<input class="form-control mr-sm-2" placeholder="Password" name="mdp" type="password">
				<input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Connexion">
			</form>
	<?php
		}
	 ?>
  </div>
</nav>

        <?= $content ?>
    </body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</html>