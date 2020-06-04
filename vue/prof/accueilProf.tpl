<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
	<link href="./vue/utilisateur/CSS/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="./vue/utilisateur/CSS/style.css" rel="stylesheet" type="text/css">
	<link href="./vue/utilisateur/CSS/linecons.css" rel="stylesheet" type="text/css">
	<link href="./vue/utilisateur/CSS/font-awesome.css" rel="stylesheet" type="text/css">
	<link href="./vue/utilisateur/CSS/responsive.css" rel="stylesheet" type="text/css">
	<link href="./vue/utilisateur/CSS/animate.css" rel="stylesheet" type="text/css">

	<link href='https://fonts.googleapis.com/css?family=Lato:400,900,700,700italic,400italic,300italic,300,100italic,100,900italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Dosis:400,500,700,800,600,300,200' rel='stylesheet' type='text/css'>

	<script type="text/javascript" src="./vue/utilisateur/js/bootstrap.js"></script>
	<script type="text/javascript" src="./vue/utilisateur/js/jquery-scrolltofixed.js"></script>
	<script type="text/javascript" src="./vue/utilisateur/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="./vue/utilisateur/js/jquery.isotope.js"></script>
	<script type="text/javascript" src="./vue/utilisateur/js/wow.js"></script>
	<script type="text/javascript" src="./vue/utilisateur/js/classie.js"></script>
</head>

<body>
	<?php require("./vue/menu.tpl"); ?>
	<section id="top_content" class="top_cont_outer">
		<div class="top_cont_inner">
			<div class="container">
				<div class="top_content">
					<div class="row">
						<div class="col-lg-5 col-sm-7">
							<div class="top_left_cont flipInY animated">
								<h2> Bienvenue
								<?php printf ('M. %s', $login); echo ('<br/>');?></h2>
								<p> <?php 
									print_r ($_SESSION['profil']['nom']." ".$_SESSION['profil']['prenom']);echo ('<br/>');
									print_r ($_SESSION['profil']['email']);echo ('<br/>');
									print_r ($_SESSION['profil']['date_prof']);echo ('<br/>');
									?></p>
								<a href="index.php?controle=prof&action=page_profile" class="learn_more2">Voir votre profil</a> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require("./vue/prof/services.tpl"); ?>

</body></html>


