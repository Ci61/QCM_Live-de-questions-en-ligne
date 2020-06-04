



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Réponse</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">
</head>

<body>
		
	<div class="container-contact3">
	<div class="wrap-contact3">
	<!-- Begin Page Content -->
	<div class="container-fluid">	<form method="post" name="testeur" action="index.php?controle=prof&action=enregistrer_reps" >
		
			Thème : 
			<?php
			print_r($_SESSION['créer_question']['theme']);
			?>
			<br>
			Question : 
			<?php
			print_r($_SESSION['créer_question']['question']);
			?>
			<br> Choisir les réponses  : 
			<?php
				for ($i = 1; $i <= $_SESSION['créer_question']['nb_rep']; $i++)
				{
					?>
					<fieldset>
						<label for="name">Entrez la réponse :</label>
						<input type="text" id="rep" name="rep<?php echo $i; ?>"  pattern="[a-zA-Z][a-zA-?-Z\s]{1,50}" placeholder="Veuillez saisir des lettres" minlength=1 maxlength=50 size="30"/>
						<?php
						if($_SESSION['créer_question']['bmultiple']=="oui"){
							?>
							<label for="name">Est une réponse :</label>
							<input type="checkbox" name="Est_rep<?php echo $i; ?>" value="<?php echo $i; ?>" checked>
							<?php
						}
						else {
							?>
							<label for="name">Est une réponse :</label>
							<input type="radio" name="Est_rep" value="<?php echo $i; ?>" checked>
							<?php
						}
						?>
					</fieldset>
					
					<?php
				}
			
			?>
			<?php
				echo('<p style=" color:red;">');
				print_r($message);
				echo('</p>');
			?>
			<input type="submit" name="submit" value="Créer" />

			
			<input type="submit" name="submit" value="Abandonner" />
		</form>
</div>
</div>
</div>
 </body>
 </html>