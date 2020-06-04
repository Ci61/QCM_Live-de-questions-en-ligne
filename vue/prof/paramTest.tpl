<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Param Test</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">

</head>

<body>
<div class="container-contact3">
<div class="wrap-contact3">
<div class="container-fluid">
	<form method="post" action="#" class="contact3-form validate-form"> 
	 	<!-- Title -->
		 <?php 
				echo("<div class='contact3-form-title'>");
				echo("<h1 class=' mb-2 text-gray-800'>Groupe concerné : ".$_SESSION['numero du groupe']."</h1><br>");
				echo ("<h6>Nombre total d'élèves du groupe : ".$nbEleve."</h6><br>");
				echo("<h6>Nombre d'élèves connectés : ".$nbEleveConnect."</h6><br>");
				echo("</div></br>");
				if (count($sujet) != 0) { 
						foreach ($sujet as $i =>$QduT) {

							echo("<div class='card shadow mb-4'>");
							$nbManquant = $nbEleve-count($compteurEtu[$i]);
		?>
		<!-- Table Questions -->
		
		<div class='card-header py-3'>
			<div class="row"><h6 class="m-0 font-weight-bold text-primary"> LA QUESTION : <?php echo($QduT[0]['texte']); ?></h6>
			</div>
		</div>

		<div class="card-body">
			<div class="toggle_radio">
											<input type="radio" class="toggle_option first"  id="<?php echo($QduT[0]['id_quest']); ?>.1"  name="<?php echo($QduT[0]['id_quest']); ?>" value="actif"
											<?php 
												if($lesQuestions[$i]['bAutorise']==1){
													echo(' checked');
												}
												?> 
											>
											<label for="<?php echo($QduT[0]['id_quest']); ?>.1" 
											<?php 
											if($lesQuestions[$i]['bAutorise']==1){
												echo(' class="vrai" ');
											}
											?>
											>Active</label>
										
											
											<input type="radio" value="annule" class="toggle_option second" id="<?php echo($QduT[0]['id_quest']) ;?>.2" name="<?php echo($QduT[0]['id_quest']) ;?>"
											<?php 
											if($lesQuestions[$i]['bAnnule']==1){
												echo('	checked');
											}
											?>
											>
											<label for="<?php echo($QduT[0]['id_quest']); ?>.2" 
											<?php 
											if($lesQuestions[$i]['bAnnule']==1){
												echo(' class="vrai" ');
											}
											?> 
											>Cancel</label>
											
											
											<input type="radio" value="bloque" class="toggle_option third" id="<?php echo($QduT[0]['id_quest']) ;?>.3" name="<?php echo($QduT[0]['id_quest']); ?>"
											<?php 
											if($lesQuestions[$i]['bBloque']==1){
												echo(' checked');
											}
											?>
											>
											
											
											<label for="<?php echo($QduT[0]['id_quest']); ?>.3" 
											<?php 
											if($lesQuestions[$i]['bBloque']==1){
												echo(' class="vrai" ');
											}
											?>
											>Block</label>
											<div class="toggle_option_slider">
											</div>
				</div>
			<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Nombre d'élèves n'ayant pas encore répondu</th>
								<th width="60%">La réponse</th>
								<th>Nombre d'élèves l'ayant choisie</th>

							</tr>
						</thead>
						<tbody>
							
								
								<?php echo("<div>");
								echo("<tr>");
								echo('<td class="noRep"rowspan='.sizeof($R[$i]).">".$nbManquant."</td>");
										foreach ($R[$i] as $j =>$petit) {
										
										
										echo("<td>");
											if($R[$i][$j]['bValide']=='1'){
												echo('<div class="vrai"><p>');
											}
											else{
												echo('<div class="faux"><p>');
											}
											echo($R[$i][$j]['texte_rep']."</p></td></div>");
												 echo('<td class="noRep">'.$R[$i][$j][0][0]['nbChoisi']."</td>");
											echo("</tr>");	
										}
										 
									?>
								
							<!-- </tr> -->
						</tbody>
					</table> 
				</div>
			</div>
			
			<?php echo("</div>"); ?>
			</br>
			</br>
			</br><?php }} else{
										echo("Pas de questions pour ce test !!");
									} ?>
        <!-- End Table -->
				<input type="submit" name="submitDuParam" value="Valider" />
				<input type="submit" name="submitDuParam" value="Finir le test" />
</form> 
</div>
</div>
</div>

</body>

</html>