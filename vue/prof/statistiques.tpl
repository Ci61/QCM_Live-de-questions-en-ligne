<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Statistique</title>
		<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">
		<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/stat.css">

	</head>

	<body>
		<div class="container-contact3">
		<div class="wrap-contact3">
		<!-- Begin Page Content -->
		<div class="container-fluid">
				<div>

					<form method="post" action="#">
						<fieldset>
							<legend>Sélectionner un test</legend>
								<?php 
									if (count($testDuJour) != 0) {
										echo ('<select class="form-control form-control-sm" name="leTest">');
										echo('<option value="">---</option>');
										foreach ($testDuJour as $i =>$tst) {		
											$num = $i;
											$id = 'test' . sprintf('%d', $num);
								?>
											<option value="<?php echo $tst['id_test']; ?>" name="tests[<?php echo $num; ?>]" 
											<?php 
											if(isset($_POST['leTest'])){

												if ($_POST['leTest']==$tst['id_test']){						
													echo(' selected="selected"');
												}
											
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
										
										echo("</select");
									}
									 else 
										echo ('</br>Aucun test n\'a été lancé aujourd\'hui.');
										
								?>
						</fieldset>	
						
					<?php 
						if (count($testDuJour) != 0) {
							echo('<input type="submit" name="submit" value="+" />');
						}
					?>
						<input type="submit" name="submit" value="Retour" />
					
					</form>
				</div>





				<div>
					<?php 
					if(isset($_POST['leTest'])&& $_POST['leTest']!=""){ 
					
						if(!empty($groupeLie)){
							forEach($groupeLie as $k=>$gr){
								echo('<div>');
								
								echo("Date du test: ".date("Y-m-d")."<br>");
								echo("Groupe concerné :".$gr."<br>");
								echo ("Nombre total d'élèves : ".$nbEleve[$k]."</br></br>");
								
						?>
								<table id="laTable">
									<tr>
										<td colspan="1">&nbsp;</td>
										<?php
											forEach($texteQ as $p=>$z){	
												echo('<th class="titre" colspan="'.$nombreR[$p][0]['nb'].'" scope="texteQ" >'.$z[0]['texte']. " </th>");
											}
										?>
											<th colspan="1" scope="texteQ" > Note </th>
									</tr>
									<tr>
										<td colspan="1">&nbsp;</td>
										<?php
											foreach($R as $o){
												if(sizeof($o)>1){
													forEach($o as $p){
														echo('<th style="height: 100px;" colspan="1"scope = "col"');
														if($p['bValide']==1){
															echo(' class="green" ');
														}
														echo('>'.$p['texte_rep'].'</th>');
													}
												}
												else{
													echo('<th colspan="1" scope = "col" ');
													if($o[0]['bValide']==1){
														echo(' class="green" ');
													}
													echo('>'.$o[0]['texte_rep'].'</th>');
													}
											}
											echo('<th colspan="1"></th>');
											echo("</tr>");

							
											foreach($eleve[$k] as $i=>$e){
												echo('<tr style="height: 100px;">');
												echo ('<th  colspan="1" scope="row">'.$e['nom']."  ".$e['prenom']."</th>");
												forEach($rep[$k][$i] as $s){/*afficher reponse eleve pour ch de boucle*/
													if($s!='x'){
														echo('<td colspan="1"><h2>o</h2></td>');
													}
													else{
														echo('<td colspan="1"><h2>x</h2></td>');
													}
									
												}
												echo("<td><h4>".$eleve[$k][$i]['note']."</h4></td>");
												echo("</tr>");
											}
							
										
											echo("</table></br>");
											
											echo("La moyenne de la classe est : ".$moyGroup[$k]);
											echo("</div></br>");
							}
						}
						else{
							echo("Aucun groupe n'a répondu à ce test aujourd'hui.");
						}
							
					}
				
					else{
						echo("Nombre total d'élèves : NULL <br>");
						echo("Date du test : NULL <br>");
						echo("Groupe concerné : NULL <br>");
					}
				?>
				<br>
				</div>
			</div>
		</div>
</div>
	</body>
</html>