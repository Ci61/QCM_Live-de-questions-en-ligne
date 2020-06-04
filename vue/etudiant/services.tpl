<!--Service-->



	<section id="service">
		<div class="container">
			<h2>Services</h2>
			
			<div class="service_area">
				<div class="row">
				<form method="post" action="index.php?controle=etudiant&action=choix_action">
					<div class="col-lg-6 ">
							<div class="title-1 fadeInDown animated"><h4> Sélectionnez le test :</h4></div>
							<div class="service_block-1 fadeInDown animated">
								
										<?php 					
											if (count($_SESSION['tests']) != 0) {
												echo ('<select class="form-control form-control-sm" id="nom_test" name="nom_test">');
												foreach ($_SESSION['tests'] as $t) {		
													$o= "<option value='%s'> %s </option>";
													$nomTest=$t['titre_test'];
													printf ($o, $nomTest,''.$nomTest);
												}
												echo ('</select></br>');
												echo('<input type="submit"  name="btn_choix" style=" margin-top:5px" value="Lancer le test" /></div>');
											}
											else {
												echo ("Aucun test n'est disponible");
											}		
										?>
					</div>
					<div class="col-lg-6 ">
							<div class="title-2  fadeInDown animated"><h4> Résultats de la session en cours :</h4></div>
							<div class="service_block-2  fadeInDown animated">
								<!-- <input type="image" src="./vue/utilisateur/img/stats.png" name="btn_choix"  onclick="submit" value="Stats"> -->
								<button type="submit" name="btn_choix" value="Stats"><img src="./vue/utilisateur/img/stats.png"> </button>
							</div>
					</div>
					
				</form>
				</div>
			</div>
					
			
		</div>		
	</section>
	<!--Service-->
