<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lancer_Test</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
</head>


<body>
<div class="container-contact3">
<div class="wrap-contact3">
<form method="post" name="lanceur" action="index.php?controle=prof&action=lancer_test" id="selection" novalidate>
			<div class="select-grp">
			<legend>Sélectionner un groupe</legend>
				<?php 
					if (count($_SESSION['lesGroupes']) != 0) {
						echo ('<select class="form-control form-control-sm" searchable="Search here.." name="leGroupe" >');
						echo('<option value="">---</option>');
						foreach ($_SESSION['lesGroupes'] as $i =>$gr) {		
							$num = $i;
							$id = 'groupe' . sprintf('%d', $num);
				?>
						<option value="<?php echo $gr['num_grpe']; ?>" name="groupes[<?php echo $num; ?>]" 
						<?php 
						if(isset($_POST['leGroupe'])){

							if ($_POST['leGroupe']==$gr['num_grpe']){						
								echo(' selected="selected"');
							}
						}
						else{
							echo("");
						}
						?>
						id="<?php echo $id; ?>">
						<?php echo ("gr".$gr['num_grpe']); ?>

				<?php
						echo("</option>");
						}
						echo("</select>");
						
					}
					 else 
						echo ('</br>pas de groupe dans la base');
						
				?>	
			</div>
	<div class="select-test">
	<legend>Sélectionner un test</legend>
	<?php 
		if (count($test) != 0) {
			echo ('<select class="form-control form-control-sm" searchable="Search here.." name="leTest">');
			echo('<option value="">---</option>');
			foreach ($test as $i =>$tst) {		
				$num = $i;
				$id = 'test' . sprintf('%d', $num);
	?>
				<option value="<?php echo $tst['id_test']; ?>" name="tests[<?php echo $num; ?>]" 
				<?php 
						if(isset($_POST['leTest'])){
							if ($_POST['leTest']==$tst['id_test'])				
								echo(' selected="selected"');
						}
						else{
							echo("");
						}
				?>
				id="<?php echo $id; ?>">
				<?php echo ($tst['titre_test']); ?>

	<?php		
	echo("</option>"); 
			}
			
			echo("</select>"); 
		}
		else 
			echo ('</br>pas de groupe dans la base');	
	?>	

	<div class="row">
			<input type="submit" name="submit" value="Lancer" >
			<input type="submit" name="submit" value="Retour" >
			</div>	
</div>

		</form>
</div>
</div>
</body>
</html>