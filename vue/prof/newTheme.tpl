



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Theme</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">
		<link rel="stylesheet" type="text/css" href="./vue/prof/newTheme.css">
</head>

<body>
	<div class="container-contact3">
	<div class="wrap-contact3">
	<!-- Begin Page Content -->
	<div class="container-fluid">	
		<form method="post" name="testeur" action="index.php?controle=prof&action=enregistrer_theme" >
			<fieldset id="theme">

				<?php 
				//print_r($theme);
					if (count($theme) != 0) {
						echo('<h2> Liste des thèmes </h2></br>');
						echo("<ul>");
						foreach ($theme as $i =>$th) {		
							//$num = $i;
							//$id = 'theme' . sprintf('%d', $num);
							echo("<li>");
							print($th['titre_theme']);
							echo("</li>");
				?>
				
				<?php
						}
						echo("</ul>");
					}
					 else 
						echo ("</br>Il n'y a pas de thèmes");
						
				?>
			</fieldset>
			<fieldset class="nom">
			<label for="name">Entrez le nom du thème :</label>
				<input type="text" id="nom" name="nom" pattern="[a-zA-Z]{2,29}" placeholder="Veuillez saisir des lettres" minlength=2 maxlength=30 size="30"/>
					
			</fieldset>
			<fieldset  class="nom">
			<label for="name">Entrez la description du thème :</label>
				<input type="text" id="description" name="description"  pattern="[a-zA-Z][a-zA-?-Z\s]{2,50}" placeholder="Veuillez saisir des lettres" minlength=2 maxlength=50 size="30"/>
					
			</fieldset>
			<?php
				echo('<p style=" color:red;">');
				print_r($message);
				echo('</p>');
			?>
			<br>
			<input type="submit" name="submit" value="Créer" />
			<input type="submit" name="submit" value="Abandonner" />
			

		</form>

</div>
</div>
</div>
 </body>
 </html>