<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stats</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">

</head>

<body>
<div class="container-contact3">
	<div class="wrap-contact3">
		<div class="container-fluid">

			<?php 
				echo("<div class='contact3-form-title'>");
				echo("<h1 class=' mb-2 text-gray-800'>Résultat pour la session en cours de l'étudiant</h1><br>");
				echo("</div>"); 
				$bonne_rep ='';
				if (count($resultat) != 0) {
					foreach($test as $i => $t){
						$nb_bonne_rep = 0;
						$r_trouvée = false;
						$liste_rep_mult = array();
				
						$sur_combien = 0;
						echo("<b>Résultat du test : ");
						printf ('%s', $t['titre_test']);
						echo('</b><br>');
					
						$note = 0;
						$nb_total = 0;
						$nb_rep_bonne_total = 0;
						$nb_rep_fausse_total = 0;
						$liste_rep_oubliée_total = array();
						$liste_truc_machin_chouette = array();
						
						foreach($questions as $q){
							
							$liste_rep_bonne_q = array();
							$liste_rep_fausse_q = array();
							$liste_rep_oubliée_q = array();
							if ($q['id_test']['id_test']==$t['id_test']){
								echo("<div class='card shadow mb-4'>");
								echo ('<div class="card-header py-3"><div class="row"><h6 class="m-0 font-weight-bold text-primary">LA QUESTION :  ');
								printf('%s',$q['texte']);
								echo('</h6></div></div>');
								foreach($q['réponses'] as $rep){
									//on recupère les réponses possibles 
									foreach($resultat as $r){
										if(($r['id_quest']==$q['id_quest'])&&($r['id_rep']==$rep['id_rep'])&&($t['id_test']==$r['id_test'])){
											
											echo('<p class="repond">Vous avez répondu : </p><p>');
											printf ('%s', $rep['texte_rep']);
											echo('</p>');
											if ($rep['bvalide']==true){
												$r_trouvée = true;
												$nb_bonne_rep = $nb_bonne_rep + 1;
												
												$liste_rep_bonne_q[]=$rep['texte_rep'];
												if(in_array($rep['texte_rep'],$liste_rep_oubliée_q)==true){
													unset($liste_rep_oubliée_q[array_search($rep['texte_rep'],$liste_rep_oubliée_q)]);
												}
												echo("<div class='vrai'><p>Vous avez eu bon</p></div>");
											}
											else {
												$liste_rep_fausse_q[]=$rep['texte_rep'];
												echo("<div class='faux'><p>Vous avez eu faux</p></div>");
											}
									
										}
										if(($rep['id_quest']==$q['id_quest'])&&($t['id_test']==$r['id_test'])&&($rep['bvalide']==true)){
											if(in_array($rep['id_rep'],$liste_truc_machin_chouette)==false){
											$liste_truc_machin_chouette[] = $rep['id_rep'];
											$nb_total = $nb_total + 1;
											}
										}
										if(($rep['bvalide']==true)&&(in_array($rep['texte_rep'],$liste_rep_mult)==false)&&($q['bmultiple']==true)){
											$liste_rep_mult[]= $rep['texte_rep'];
											if(in_array($rep['texte_rep'],$liste_rep_bonne_q)==false){
												$liste_rep_oubliée_q[]= $rep['texte_rep'];
											}
										}
										if (($rep['bvalide']==true)&&($q['bmultiple']==false)){
											$bonne_rep = $rep['texte_rep'];
										}
									}
								}
								if (($r_trouvée == false) || ($nb_bonne_rep != count($liste_rep_mult))){
									if (($q['bmultiple']==false)&&($r_trouvée == false)){
										echo('<p class="repond">La bonne réponse était :<br><p>');
										printf('%s',$bonne_rep);
										echo('</p>');
									}
									else if ($q['bmultiple']==true && count($liste_rep_oubliée_q)>0){
										echo('<br>');
										echo("<p>Vous n'avez pas eu toutes les bonnes réponses !</p>");
										echo('<p class="repond">La ou les bonnes réponses oubliées sont : </p>');

										foreach($liste_rep_oubliée_q as $b_rep){
											echo('<p>');
											printf(' %s',$b_rep);
											echo('</p>');
										}
										
									}
								}

								$nb_rep_bonne_total += count($liste_rep_bonne_q);
								$nb_rep_fausse_total += count($liste_rep_fausse_q);
							echo("</div>");
							}
					
							$liste_rep_mult = array();
							$bonne_rep ='';
						
						}
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
						echo('<br> Moyenne du groupe : ');
						print_r($_SESSION['moyGroup'][$i]);
						echo('/20 <br><br>');
					}
				}
				else {
					echo("Pas de résultat pour la session en cours");
				}
				echo('<form method="post" action="index.php?controle=etudiant&action=choix_action">');
				echo('<br><input type="submit"  name="btn_choix" style=" margin-top:5px" value="Retour" />');					
				echo('	</form>');
			?>
		</div>		
	</div>
</div>
</body></html>
