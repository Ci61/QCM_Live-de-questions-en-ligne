<?php 
/*controleur c1.php :
  fonctions-action de gestion (c1)
*/

function accueilProf() {
	require ('./modele/utilisateurBD.php');
	
	$login = $_SESSION['profil']['nom'];
	connectProf($_SESSION['profil']['nom']);
	select_group($_SESSION['lesGroupes']);
	require ("./vue/prof/accueilProf.tpl");
}

function deconnectProf() {
	require ('./modele/utilisateurBD.php');
	disconnectProf($_SESSION['profil']['nom']);
	$_SESSION = array();
	session_destroy();
	header('Location: index.php'); //true ou false en base;
}

function page_profile(){
	require ('./modele/utilisateurBD.php');
	require ("./vue/prof/profile_page.tpl");
}

function creer_test(){
	require ('./modele/testBD.php');
	
	$Q=array();
	select_Q($Q);
	$theme=array();
	select_theme($theme);

	if(!empty($_POST['themes'])){ //si le professeur choisit des thèmes
  		$themo=array();
		$QSelonT=array();
		
		forEach($_POST['themes'] as $i => $th){ 
	
			QT($th,$themo[$i]); 
		}
	}
	
	if(isset($_POST['submit'])){
		if( $_POST['submit']=="Voir les questions"){
			if(empty($_POST['themes'])){
				echo('<p style="color : red">Vous n\'avez pas sélectionné de thème !!</p></br>');
			}

		}  
		if( $_POST['submit']=="Créer"){
			if( isset($_POST['themo'])&& (!empty($_POST['name']))){

				$chiffre = creerNewTest(-1, $_POST['name']);
				foreach($_POST['themo'] as $q){
					
					newQCM($chiffre, $q);			
				}
				
				Retour("prof","accueilProf");
			}
			else{
				echo('<p style="color : red">Vous n\'avez pas rempli tous les paramètres !!</p></br>');
			}
		}
		if($_POST['submit']=="Abandonner"){
			unset($_POST['themes']);
			unset($_POST['groupes']);
			Retour("prof","accueilProf");
		}
	}
	
	

	require('./vue/prof/newTest.tpl');
}


function lancer_test(){
	require ('./modele/testBD.php');
	
	
	$test=array(); //la liste des tests crées par le professeur
	select_test($test);
	
	
	if(!empty($_POST['submit'])){
		if($_POST['submit']=="Lancer"){ 
			if(isset($_POST['leTest']) && isset($_POST['leGroupe'])){
				if($_POST['leTest']!="" && $_POST['leGroupe']!=""){ // on vérifie qu'un groupe et un test sont données 
					
					lancerAncienTest($_POST['leGroupe'],$_POST['leTest']); 
					
					$_SESSION["numero du groupe"]=$_POST['leGroupe'];
					$_SESSION["numero du test"]=$_POST['leTest'];
					
					$lesQuestions=array();
					selectQCM($_SESSION["numero du test"], $lesQuestions);

					$sujet=array();
					forEach($lesQuestions as $i => $qcm){
						selectQduTest( $qcm['id_quest'],$sujet[$i]);
					}
				
					forEach($sujet as $i=>$quest){
						paramQuestion($_SESSION["numero du test"],$lesQuestions[$i]["id_quest"], 0,  1, 0);
					}

					Retour("prof","paramTest");
					
					exit();
					
				}
				else{
					require('./vue/prof/lancer_Test.tpl');
				}
			}
			else{
				require('./vue/prof/lancer_Test.tpl');
			}
		}

		if($_POST['submit']=="Retour"){
			unset($_POST['leTest']);
			unset($_POST['leGroupe']);
			Retour("prof","accueilProf");
		}
	}
	
	else{
		require('./vue/prof/lancer_Test.tpl');
	}
}



function Retour($util, $act){
	header("Location: index.php?controle=".$util."&action=".$act);
	exit();
	
}

function paramTest(){
	require ('./modele/testBD.php');
	$nbEleve=nombreEleve($_SESSION['numero du groupe']);
	$nbEleveConnect=nombreEleveConnect($_SESSION['numero du groupe']);
	$lesQuestions=array();
	selectQCM($_SESSION["numero du test"], $lesQuestions);
	

	$sujet=array();
	forEach($lesQuestions as $i => $qcm){
		selectQduTest( $qcm['id_quest'],$sujet[$i]);			
	}
	
	forEach($sujet as $i=>$quest){
		select_R($R[],$sujet[$i][0]['id_quest']);
		
		foreach ($R[$i] as $j =>$petit) {
			
			compteurRepGroupe($_SESSION["numero du test"], $sujet[$i][0]['id_quest'], $R[$i][$j]['id_rep'], $R[$i][$j][],$_SESSION['numero du groupe']);
					
			
		}
		
		compteurPasDeRepGroupe($_SESSION["numero du test"], $sujet[$i][0]['id_quest'], $compteurEtu[],$_SESSION['numero du groupe']);
		
	}


	if(isset($_POST['submitDuParam'])){

		if($_POST['submitDuParam']=="Valider"){
			
			foreach ($sujet as $i =>$QduT) {
					var_dump($_POST[$QduT[0]['id_quest']]);
					var_dump($QduT);
				switch ($_POST[$QduT[0]['id_quest']]) {
						
					case "actif":
						paramQuestion($_SESSION["numero du test"],$lesQuestions[$i]["id_quest"], 1,  0, 0);
						break;
					case "bloque":
						paramQuestion($_SESSION["numero du test"],$lesQuestions[$i]["id_quest"], 0,  1, 0);
						break;
					case "annule":
						paramQuestion($_SESSION["numero du test"],$lesQuestions[$i]["id_quest"], 0,  0, 1);
						break;
				}
			
							
			}
				
				
			
			Retour("prof","paramTest");
		}
		
		if($_POST['submitDuParam']=="Finir le test"){
			
			finirTest($_SESSION["numero du test"]);
			
			foreach ($sujet as $i =>$QduT) {

				paramQuestion($_SESSION["numero du test"],$lesQuestions[$i]["id_quest"], 0,  1, 0);
			
			}
			
			Retour("prof","accueilProf");
						
		}
					
	}
				
	require('./vue/prof/paramTest.tpl');
}



function statistique(){
	
	require ('./modele/testBD.php');
	
	$testDuJour=array();
	select_test_du_jour($testDuJour);
	
	$eleve=array();

	$nbEleve=array();
	
	$moyGroup=array();
	if(!empty($_POST['submit'])){
		if($_POST['submit']=="+"){
			if(isset($_POST['leTest'])&&$_POST['leTest']!=""){
				$lesQuestions=array();
				selectQCM($_POST['leTest'], $lesQuestions);
				
				
				forEach($lesQuestions as $q){
					compteurRepParQ($q['id_quest'],$nombreR[]);
					selectQduTest($q['id_quest'], $texteQ[]);
					select_R($R[],$q['id_quest']);
				}


				$concerne= array();
				trouverGroupe($_POST['leTest'], $concerne);
				$groupeLie=array();
				forEach($concerne as $idG){		
					$num=leGroupe($idG['id_etu']);
					if (!in_array($num, $groupeLie)) {
						$groupeLie[]=$num;
					}					
				}
				
				$rep=array();

				forEach($groupeLie as $j => $groupe){
					infoEleve($groupe, $eleve[$j]);
					$nbEleve[$j]=nombreEleve($groupe);
					$moyenne=0;
					forEach($eleve[$j] as $i=>$e){
						
						$mauvaise=0;
						$bonne=0;
						$attendu=0;
						forEach($lesQuestions as $s=> $Q){

							saRepPourQ($e['id_etu'],$_POST['leTest'], $Q['id_quest'], $liste[]);

							foreach($R[$s] as $o){ 
								$bool=false;
								if($o['bValide']==1){
									$attendu+=1;
								}
								foreach($liste as $gh=> $y){
									
									if(sizeof($y)>1){
										foreach($y as $f){
											if($f['id_rep']==$o['id_rep']){
												$bool=true;
												break;
											}
										}
										if($bool==true){
											if($o['bValide']==1){
												$bonne+=1;	
											}
											else{
												$mauvaise+=1;
											}
											
											 $rep[$j][$i][]=$o['id_rep'];
										}
										else{
											$rep[$j][$i][]="x";
											
										}
									 }
									else{
										if($y[0]['id_rep']==$o['id_rep']){
											if($o['bValide']==1){
												$bonne+=1;		
											}
											else{
												$mauvaise+=1;
											}
											 $rep[$j][$i][]=$o['id_rep'];
										 }
										 else{
											 $rep[$j][$i][]="x";
										}
									}
								}
													
							}
							$liste=array();			
						}
						if($bonne>0){
							$eleve[$j][$i]['note']=(($bonne-$mauvaise*0.5)/$attendu)*20;
						}
						else{
							$eleve[$j][$i]['note']=0;
						}
						if ($eleve[$j][$i]['note']<0){
							$eleve[$j][$i]['note'] = 0;
						}
						$moyenne+=$eleve[$j][$i]['note'];
						
						
					}
							
					$moyGroup[]=($moyenne/$nbEleve[$j]);

				}

			}
		}
		else{
			unset($_POST['submit']);
			Retour("prof","accueilProf");
		}
	}
		
	require('./vue/prof/statistiques.tpl');
}

// Marine
function créer_question(){
		require ('./modele/testBD.php');
	$Q=array();
	select_Q($Q);
	$theme=array();
	select_theme($theme);
	$message ="";
	require('./vue/prof/newQuestion.tpl');
}
// Marine
function créer_réponses(){
	if (isset($_POST['submit'])&&$_POST['submit']=="Abandonner"){
		unset($_SESSION['créer_question']);
		unset($_POST['question']);
		unset($_POST['titre']);
		unset($_POST['submit']);
		Retour("prof","accueilProf");
	}
	else if (isset($_POST['submit']) && isset($_POST['question']) && $_POST['question']!="" && isset($_POST['titre']) && $_POST['titre']!="" && $_POST['submit']=="Créer"){
		$_SESSION['créer_question']['theme'] = $_POST['theme'];
		$_SESSION['créer_question']['titre'] = $_POST['titre'];
		$_SESSION['créer_question']['question'] = $_POST['question'];
		$_SESSION['créer_question']['bmultiple'] = $_POST['bmultiple'];
		$_SESSION['créer_question']['nb_rep'] = $_POST['nb_rep'];
		$message = "";
		require('./vue/prof/newReps.tpl');
	}	

	else {
		require ('./modele/testBD.php');
		$Q=array();
		select_Q($Q);
		$theme=array();
		select_theme($theme);
		$message ="Veuillez remplir tous les champs";
		require('./vue/prof/newQuestion.tpl');
	}
	
}
// Marine
function enregistrer_reps(){
	$réponses=array();
	$ok = 1;
	if (isset($_POST['submit'])&&$_POST['submit']=="Abandonner"){
		unset($_POST['submit']);
		Retour("prof","créer_question");
	}
	else if (isset($_POST['submit']) && $_POST['submit']=="Créer"){
		$compteur=0;
		for ($i = 1; $i <= $_SESSION['créer_question']['nb_rep']; $i++){
			
			if(isset($_POST['rep'.$i])&&$_POST['rep'.$i]!=""){ 
				$réponses[$i]['texte_rep'] = $_POST['rep'.$i];
				if($_SESSION['créer_question']['bmultiple']=="oui"){
					if(isset($_POST['Est_rep'.$i])){
						$réponses[$i]['bValide']=1;
						$compteur+=1;
					}
					else {
						$réponses[$i]['bValide']=0;
					}
				}
				else {
					if($_POST['Est_rep']==$i){
						$réponses[$i]['bValide']=1;
					}
					else{
						$réponses[$i]['bValide']=0;
					}
				}
			}
			else {
				$ok=0;
				$message ="Il faut écrire chaque réponse";
				break;
			}
		}
		if($ok==1){
			if($_SESSION['créer_question']['bmultiple']=="oui" && $compteur<2){
				$message ="Il faut plusieurs réponses valides !";
				require('./vue/prof/newReps.tpl');
			}
			else{
				require ('./modele/testBD.php');
				enregistrer_question_BD();
				enregistrer_reps_BD($réponses);
				unset($_SESSION['créer_question']);
				Retour("prof","accueilProf");
			}
		}
		else{
			require('./vue/prof/newReps.tpl');
		}
		
	}	
}
// Marine
function créer_theme(){
	require ('./modele/testBD.php');
	
	
	$Q=array();
	select_Q($Q);
	$theme=array();
	select_theme($theme);
	$message="";
	require('./vue/prof/newTheme.tpl');
}
// Marine
function enregistrer_theme(){
	require ('./modele/testBD.php');
	$Q=array();
	select_Q($Q);
	$theme=array();
	select_theme($theme);
	
	$nom_test="";
	$description_test= "";
	
	if(isset($_POST['submit'])){
		if ($_POST['submit']=="Abandonner"){
			unset($_POST['submit']);
			unset($_POST['nom']);
			unset($_POST['description']);
			Retour("prof","créer_question");
		}
		else{
			if($_POST['submit']=="Créer"){
				if(isset($_POST['nom']) && $_POST['nom']!=""){
					$nom_test= $_POST['nom'];
				}
				if(isset($_POST['description']) && $_POST['description']!=""){
					$description_test= $_POST['description'];
				}
				if($nom_test !="" && $description_test !=""){
					
					enregistrer_theme_bd($nom_test, $description_test);
					Retour("prof","créer_question");
				}
				else {
					
					$message="Il faut remplir tous les champs";
					
				}
			}

		}
	}

	require('./vue/prof/newTheme.tpl');


}

?>


