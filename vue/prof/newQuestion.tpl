



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>newQuestion</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
		<!-- <link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css"> -->
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/newQ.scss">
</head>

<body>
<div class="container-contact3">
<div class="wrap-contact3">
<!-- Begin Page Content -->
<div class="container-fluid">
		<form method="post" name="testeur" action="index.php?controle=prof&action=créer_réponses" >
			<fieldset>
			<label class="consigne">Choisissez un thème</label></br>
				<?php 
					if (count($theme) != 0) {
						foreach ($theme as $i =>$th) {		
							$num = $i;
							$id = 'theme' . sprintf('%d', $num);
				?>
						<input type="radio" name="theme" value="<?php echo $th['titre_theme']; ?> "
						<?php 
							
							echo("checked");

						?>
						id="<?php echo($th['titre_theme']);?>">
						<label class="selection" for="<?php echo $th['titre_theme']; ?>"><?php echo $th['titre_theme']; ?></label>
				<?php
						}
					}
					 else 
						echo ('</br>pas de theme dans la base');
						
				?>
			<div class="row"><label class="consigne">Créer un thème</label>
			<p><a class="effect1" href="index.php?controle=prof&action=créer_theme">par ici<span class="bg"></span></a></p></div>
			</fieldset>
	
				<fieldset>
				<label class="consigne" for="name">Entrez le titre :</label>
					<input type="text" id="titre" name="titre"  pattern="[a-zA-Z][a-zA-?-Z\s]{2,50}" placeholder="Veuillez saisir des lettres" minlength=2 maxlength=50 size="30"/>						
				</fieldset>
				<fieldset>
				<label class="consigne" for="name">Entrez la question :</label>
					<input type="text" id="question" name="question"  pattern="[a-zA-Z][a-zA-?-Z\s]{2,50}" placeholder="Veuillez saisir des lettres" minlength=2 maxlength=50 size="30"/>
						
				</fieldset>
				<fieldset>
				<label class="consigne" for="name">Question à choix multiple :</label>
					<input type="radio" name="bmultiple" value="oui" id="oui"><label class="selection" for="oui">oui</label>
					<input type="radio" name="bmultiple" value="non" id="non"checked><label class="selection" for="non">non</label>
				</fieldset>
				<fieldset>
				<label class="consigne" for="name">Nombre de propositions :</label>
					<input type="radio" name="nb_rep" value="2" id="id-rep1"><label class="selection" for="id-rep1">2</label>
					<input type="radio" name="nb_rep" value="3" id="id-rep2"><label class="selection" for="id-rep2">3</label>
					<input type="radio" name="nb_rep" value="4" id="id-rep3" checked><label class="selection" for="id-rep3">4</label>
				</fieldset>

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