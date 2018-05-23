<?php $title='Les aventures de Jean Forteroche'; ?>

<?php ob_start(); ?>

<!-- #slidehomepage  -->
<!-- toutes les images proviennent de pixabay.fr et la pluspart de skeeze/Noel-Bauza/steveowst/-->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
	<li data-target="#carouselExampleIndicators" data-slide-to="9"></li>
  </ol>
  <div class="carousel-inner">
	<div class="carousel-item active">
		<img class="d-block w-100" src="public/images/homepage/1_slide_skeeze.jpg" alt="paysage:Alaska, source:Pixabay, autor:Skeeze">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption">Bienvenue en Alaska !</h2>
			<p class="pslide">La Grande Terre</p>
		</div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="public/images/homepage/2_slide_sab_k.jpg" alt="paysage:Alaska, source:Pixabay, autor:sab_k">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">Au départ ...</h2>
			<p class="pslide">un chemin</p>
		</div>
    </div>
    <div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/3_slide_Noel_Ba	uza.jpg" alt="paysage:Alaska, source:Pixabay, autor:Noel Bauza">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">Une découverte ...</h2>
			<p class="pslide">hors du commun<p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/4_slide_Noel_Ba	uza.jpg" alt="paysage:Alaska, source:Pixabay, autor:Noel Bauza">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">A la rencontre ...</h2>
			<p class="pslide">des autres et de soi-même</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/5_slide_steveowst.jpg" alt="paysage:Alaska, source:Pixabay, autor:steveowst">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">La nuit ici ...</h2>
			<p class="pslide">illumine vos âmes</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/6_slide_skeeze.jpg" alt="paysage:Alaska, source:Pixabay, autor:Skeeze">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">La nuit ici ...</h2>
			<p class="pslide">les Dieux dessinent dans les étoiles</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/7_slide_skeeze.jpg" alt="paysage:Alaska, source:Pixabay, autor:Skeeze">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">A l'aube, la nuit s'éteint...</h2>
			<p class="pslide">les Dieux laissent leurs pinceaux</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/8_slide_Patjosse.jpg" alt="paysage:Alaska, source:Pixabay, autor:Patjosse">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">L'homme reprend ses droits,</h2>
			<p class="pslide">l'activité repart</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/9_slide_Free-Photos.jpg" alt="paysage:Alaska-ours, source:Pixabay, autor:Free-Photos">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">Mais la nature domine,</h2>
			<p class="pslide">ici nous sommes d'abord dans son Royaume</p>
		</div>
    </div>
	<div class="carousel-item">
		<img class="d-block w-100" src="public/images/homepage/10_slide_skeeze.jpg" alt="paysage:Alaska, source:Pixabay, autor:Skeeze">
		<div class="carousel-caption d-none d-md-block">
			<h2 class="slidecaption ">Ici nous sommes rien,</h2>
			<p class="pslide">nous contemplons seulement !</p>
		</div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templateFront.php'); ?>
