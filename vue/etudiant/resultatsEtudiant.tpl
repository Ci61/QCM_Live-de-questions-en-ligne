<!doctype html>
<html lang="fr">

<head>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Resultat</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
  	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
</head>

<body>

<div class="container-contact3">
<div class="wrap-contact3">
<div class="container-fluid">
			<?php 
	echo ('<h1>');
	echo('Résultats du ');
	printf ('%s', $nom_test);	
	echo('</h1>');
	echo('<br>');						
	echo('	<form method="post" action="index.php?controle=etudiant&action=choix_action" class="contact3-form validate-form">');
		$nb_total = 0;
		$nb_rep_bonne_total = 0;
		$nb_rep_fausse_total = 0;
		foreach ($questions as $q) {	
		
			
			if (($q['booléens']['bAnnule']==false)&&($q['b_repondu']==false)){
				echo("<div class='card shadow mb-4'>");
				echo ('<div class="card-header py-3"><div class="row"><h6 class="m-0 font-weight-bold text-primary">LA QUESTION :  ');
				printf('%s',$q['texte']);
				echo('</h6></div></div>');
				$bool_réussi = true;
				$bonne_rep = '';
				$nb_bonne_rep = 0;
				$bonnes_reps = array();
				$liste_rep_oubliée_q=array();
				
				foreach ($q['réponses'] as $rep){
					if ($q['bmultiple']==false){
						if (($q['booléens']['bBloque']==false)){
							if (($rep['id_rep']==$q['resultat'])&& ($rep['bvalide']==true)){
								$nb_rep_bonne_total =$nb_rep_bonne_total +1;
								echo ('<p class="repond">Vous avez répondu : ');
								printf('%s',$rep['texte_rep']);
								echo('</p><br><p>Vous avez eu bon !</p>');

							}
							else if(($rep['id_rep']==$q['resultat'])&& ($rep['bvalide']==false)){
								echo ('<p>Vous avez répondu : ');
								printf('%s',$rep['texte_rep']);
								echo('</p><br><p>Vous avez eu faux !</p>');
								$bool_réussi = false;
								$nb_rep_fausse_total = $nb_rep_fausse_total +1;
							}
						}
						else {
							$bool_réussi = false;
						}
						if (($rep['bvalide']==true)){
							$nb_total = $nb_total + 1;
							$bonne_rep = $rep['texte_rep'];
						}
					}
					else {
						
						if (($q['booléens']['bBloque']==false)){
							foreach($q['resultat'] as $res){
								if (($q['booléens']['bBloque']==false)){
									
									if (($rep['id_rep']==$res)&& ($rep['bvalide']==true)){
										echo ('<p>Vous avez répondu : ');
										echo('<br>');
										printf(' %s',$rep['texte_rep']);
										echo('</p><div class="vrai"><p>Vous avez eu bon !</p></div>');
										$bonnes_reps[]=$rep['texte_rep'];												
										$nb_rep_bonne_total =$nb_rep_bonne_total +1;
										if(in_array($rep['texte_rep'],$liste_rep_oubliée_q)==true){
											unset($liste_rep_oubliée_q[array_search($rep['texte_rep'],$liste_rep_oubliée_q)]);
										}
									}

									else if (($rep['id_rep']==$res)&& ($rep['bvalide']==false)){
										echo ('<p>Vous avez répondu : ');
										echo('<br>');
										$bool_réussi = false;
										printf(' %s',$rep['texte_rep']);
										echo('</p><div class="faux"><p>Vous avez eu faux !</p></div>');
										$nb_rep_fausse_total = $nb_rep_fausse_total +1;
									}
								 //}
								}
								else {
									$bool_réussi = false;
								}
								
							}
							
							if (($rep['bvalide']==true)){
								$nb_total = $nb_total + 1;
								$nb_bonne_rep = $nb_bonne_rep + 1;
								if(in_array($rep['texte_rep'],$bonnes_reps)==false){
										$liste_rep_oubliée_q[]= $rep['texte_rep'];
								}
							}
						}
						
					
					}
				}
			
			/*questions finies*/
			
				echo('</p>');
				if (($bool_réussi == false) || ($nb_bonne_rep != count($bonnes_reps))){
					if ($q['booléens']['bBloque']==true){
						echo("<p>Vous n'avez pas répondu <br></p>");
					}			
					if ($q['bmultiple']==false && $q['booléens']['bBloque']==false){
						echo('<p>');
						echo('La bonne réponse était : ');
						printf('%s',$bonne_rep);
						echo('</p>');
					}
					else if(count($liste_rep_oubliée_q)>0 && $q['booléens']['bBloque']==false){
						echo('<p><br>');
						echo("Vous n'avez pas eu toutes les bonnes réponses !");
						echo('</p><br>');
						echo('<p>La ou les bonnes réponses manquantes sont : <br>');
						foreach($liste_rep_oubliée_q as $b_rep){
							printf(' %s',$b_rep);
							echo('</p><br>');
						}
					}
				}
			
				echo("</div>");
			}
		}
			echo('<br>');
			echo('Nombre de attendus de réponses : ');
			print_r($nb_total);
			echo('<br>Nombre de réponses fausses : ');
			print_r($nb_rep_fausse_total);
			echo('<br>Nombre de réponses bonnes : ');
			print_r($nb_rep_bonne_total);
			if($nb_rep_bonne_total>0){
				echo('<br>Note : ');
				print_r(($nb_rep_bonne_total-($nb_rep_fausse_total/2)));
				echo('/');
				print_r($nb_total);
				echo('<br>Note sur 20: ');
				print_r((($nb_rep_bonne_total-($nb_rep_fausse_total/2))*20)/$nb_total);
				echo('/20');
				echo('<br>');
			}
			else {
				echo('<br>Note : 0/');
				print_r($nb_total);
				echo('<br>Note sur 20: 0/20');
				echo('<br>');
				
			}
		echo('<input type="submit" name = "btn_choix" style=" margin-top:5px" value="Retour Accueil" />');
	echo('	</form>');
?>
	</div>		
	</div>
	</div>

</body></html>
