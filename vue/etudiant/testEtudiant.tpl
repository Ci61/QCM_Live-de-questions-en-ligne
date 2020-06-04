<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stats</title>
    <link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/newQ.scss">
</head>

<body>

<div class="container-contact3">
	<div class="wrap-contact3">
		<div class="container-fluid">
			<h3> 	
				<?php 
					echo("<div class='contact3-form-title'>");
					echo("<h1 class=' mb-2 text-gray-800'>Lancement du: ".$nom_test."</h1><br>");
					echo ("<h5> Sélectionnez les réponses  :</h5>");
					echo("</div>"); 						
					echo('<form method="post" action="index.php?controle=etudiant&action=valider_résultats">');
						if (count($questions) != 0) {
							
							$i = 0;	
							//nombre de questions auxquelles l'élève peut répondre
							$nb_questions_effectives=0;
							foreach ($questions as $q) {	
								//gestion blocage à faire
					
								echo ('<div class="card-header py-3"><div class="row"><h6 class="m-0 font-weight-bold text-primary">LA QUESTION :  ');
								printf('%s',$q['texte']);
								echo('</h6></div></div>');
								echo('<div class="card-body">');
								if ($q['b_repondu']==false){
									if (($q['booléens']['bBloque']==false)&&($q['booléens']['bAnnule']==false)&&($q['booléens']['bAutorise']==true)){
										$j=0;
										foreach ($q['réponses'] as $p=>$rép) {					
											if ($q['bmultiple']==false){									
												echo('<input type="radio"  id="'.$rép['id_rep'].'" name="réponse'.$i.'" value="'.$rép['id_rep'].'">');
												echo('<label class="selection" for="'.$rép['id_rep'].'">'.$rép['texte_rep'] .'</label> ');
											}
											else {
												echo('<input type="checkbox"  id="'.$rép['id_rep'].'" name="réponse'.$i.$j.'" value="'.$rép['id_rep'].'">');
												echo('<label class="selection" for="'.$rép['id_rep'].'">'.$rép['texte_rep'] .'</label> ');
												$j = $j + 1;
											}
										}
										$i = $i+1;
										$nb_questions_effectives = $nb_questions_effectives + 1;
									}
									else if (($q['booléens']['bBloque']==false)&&($q['booléens']['bAnnule']==true)){
										echo("La question est annulée");
									}
									else if (($q['booléens']['bBloque']==true)&&($q['booléens']['bAnnule']==false)){
										echo("La question est bloquée, le temps alloué pour y répondre est terminé");
									}
								}
								else {
									echo("<h6>Vous avez déjà répondu à cette question aujourd'hui</h6>");
									$i = $i+1;
								}
								echo('</div>');
							}

							echo('<div class="faux"><p>');
							print_r($message);
							echo('</p></div>');
							echo('<br>');
							//il n'y a pas de réponses aux questions à valider 
							if ($nb_questions_effectives>0){
								echo('<input name="boutonSuite" type="submit" style=" margin-top:5px" value="Valider les réponses" />');
							}
						}
						else {
							echo ('<pre>');
							echo ('il n y a pas de questions disponibles');
							echo('	</pre>');
						}
						echo('<input name="boutonSuite"  type="submit" style=" margin-top:5px" value="Retour" />');
					echo('</form>');
				?>
			</h3>				
		</div>		
	</div>
</div>

</body></html>
