<?php 
/*controleur c1.php :
  fonctions-action de gestion (c1)
*/



function appel_test(){
	$_SESSION['tests']=array();
	$num_grp="";
	$num_grp = $_SESSION['profil']['num_grpe'];
	$msg='';
	$bool = avoir_liste_tests($num_grp,$tests);
	if($bool){
		$_SESSION['tests']=$tests;
	}
}

function page_profile(){
	require ('./modele/utilisateurBD.php');
	require ("./vue/etudiant/profile_page.tpl");
}

function avoir_liste_tests(&$num_grp,&$tests ){
	require('./modele/etudiantBD.php');
	return avoir_liste_tests_BD($num_grp,$tests); //retourne true s'il y a des tests, faux sinon 
}

function choix_action(){
	if ($_POST['btn_choix']=='Lancer le test'){
		$nom_test=  isset($_POST['nom_test'])?($_POST['nom_test']):''; //on récupère la valeur sélectionnée 
		lancer_test($nom_test);
	}
	else if ($_POST['btn_choix']=='Stats'){
		afficher_stats();
	}
	else if ($_POST['btn_choix']=='Profil'){
		afficher_profil();
	}
	else if ($_POST['btn_choix']=='Retour Accueil'||$_POST['btn_choix']=='Retour'){
		accueil_etudiant();
	}
}

function afficher_stats(){

	require('./modele/etudiantBD.php');
	
	$resultat = array();
	avoir_résultat_BD($resultat); //on a la liste des résultats pour la session en cours soit aujourd'hui 
	
	$questions = array();
	$test =array();
	avoir_questions_BD($resultat, $questions);
	avoir_réponses_BD ($questions);
	$liste_id_test = array();
	$_SESSION['moyGroup']=array();
	
	foreach($resultat as $r){
		if ((in_array($r['id_test'],$liste_id_test)==false)){
			$liste_id_test[]=$r['id_test']; //on récupère la liste des id_test de tous les tests de passé 
			//on appelle la moyenne pour ce test 
			moyenne($r['id_test']);
		}
	}
	avoir_id_test_pour_questions($questions);
	avoir_test_id_BD($liste_id_test,$test);

	require ("./vue/etudiant/statsEtudiant.tpl");
}

function lancer_test($nom_test){ // lance un test 
	
	$_SESSION['nom_test']=$nom_test;
	require('./modele/etudiantBD.php');


	avoir_test_nom_BD($nom_test,$test);
	$_SESSION['id_test']=$test['id_test'];
	$id_test = $test['id_test'];

	avoir_id_quest_BD($id_test,$liste_id_quest);
	 
	//on récupère les questions 
	avoir_questions_BD($liste_id_quest,$questions); 
	
	//on récupère les résultats précédents
	//sert à déterminer si l'étudiant à déjà répondu à la question de ce test 
	$resultat= array();
	avoir_résultat_id_test_BD($resultat,$id_test);
	
	//$i = 0;
	foreach($questions as $i=> $q){
		
		$questions[$i]['b_repondu']='';
		$questions[$i]['b_repondu']=0;
		
		foreach($resultat as $j=>$r){
			if ($q['id_quest']==$r['id_quest']){
				$questions[$i]['b_repondu']=1;
			}
		}
	//	$i = $i + 1;
	}

	avoir_questions_b_BD($questions,$id_test);
	
	//on récupère la réponse aux questions 
	avoir_réponses_BD ($questions);
	$_SESSION['questions'] = $questions;
	$message = '';
	require ("./vue/etudiant/testEtudiant.tpl");
	
}



function valider_résultats(){
	
	if ($_POST['boutonSuite']=='Valider les réponses'){
		//il faut récupérer les résultats de l'étudiant et les insérer dans la table résultat 
		$nb_rep_attendues = 0; //nb minimum de réponse que l'étudiant doit fournir pour chaque réponse 
		$i=0;
		foreach($_SESSION['questions'] as $q){
			if (($q['booléens']['bBloque']==false)&&($q['booléens']['bAnnule']==false)){
				if ($q['bmultiple']==false){
					if (isset($_POST['réponse'.$i]) && $_POST['réponse'.$i]!=''){
						$nb_rep_attendues = $nb_rep_attendues + 1;
						$_SESSION['questions'][$i]['resultat'] = $_POST['réponse'.$i]; //on enregistre 'id de la réponse 
						
					}
					$i = $i + 1;			
				}
				else {
					$j=0;
					$_SESSION['questions'][$i]['resultat']=array();
					$compteur = 0;
					foreach($q['réponses'] as $r){
						if (isset($_POST['réponse'.$i.$j]) && $_POST['réponse'.$i.$j]!=''){
							$_SESSION['questions'][$i]['resultat'][] = $_POST['réponse'.$i.$j];
							$compteur += 1;
							
						}
						$j = $j + 1;
					}
					if ($compteur !=0){
						$nb_rep_attendues = $nb_rep_attendues + 1;
					}
					$i = $i + 1;
				}
			}
			if (($q['booléens']['bBloque']==true)||($q['booléens']['bAnnule']==true) || ($q['b_repondu']==true)){
				$nb_rep_attendues = $nb_rep_attendues + 1;
			}
			

			
		}

		//var_dump($liste_resultat);
		
		//si on a pas autant de résultat que de questions, on reste sur la page du test. 
		if ($nb_rep_attendues<count($_SESSION['questions'])){
			
			$nom_test = $_SESSION['nom_test'];
			$questions = $_SESSION['questions'];
			$message = 'il faut répondre à toutes les questions';
			require ("./vue/etudiant/testEtudiant.tpl");
		}
		else {
			//récuperer_id_test(); //pas besoin de récupérer l'id
			//si l étudiant a répondu, on affiche sa réponse et le résultat attendu 
			//et on enregistre sa réponse dans la table résultat 
			require ('./modele/resultat.php');
			enregistrer_résultat_BD();
			afficher_résultats();
		}
	}
	else if ($_POST['boutonSuite']=='Retour'){
		accueil_etudiant();
	}
}

function récuperer_id_test(){
	$i=0;
	foreach($_SESSION['questions'] as $q){
		if (($q['booléens']['bBloque']==false)&&($q['booléens']['bAnnule']==false)){
			if ($q['bmultiple']==false){
				foreach ($q['réponses'] as $rep){
					if($q['resultat']==$rep['texte_rep']) {
						$_SESSION['questions'][$i]['id_resultat'] = $rep['id_rep'];
					}	
				}
			}
			else {
				
				foreach ($q['réponses'] as $rep){
					$j=0;
					foreach($q['resultat'] as $res){
						if($res==$rep['texte_rep']) {
							$_SESSION['questions'][$i]['id_resultat'][$j] = $rep['id_rep'];
						}	
						$j = $j + 1;
					}
				}
			}
			$i = $i + 1;
		}
	}

}

function moyenne($id_test){
	
	
	
	$testDuJour=array();
	select_test_du_jour($testDuJour,$id_test);
	
	$eleve=array();

	$nbEleve=array();
	


	$lesQuestions=array();
	selectQCM($id_test, $lesQuestions); //id_test
	
	
	forEach($lesQuestions as $q){
		
		selectQduTest($q['id_quest'], $texteQ[]);
		select_R($R[],$q['id_quest']);
	}

	$concerne= array();
	trouver_etudiants_groupe($id_test, $concerne); //met dans concerne la liste des étudiants du groupe ayant passé le test 
	// $groupeLie=array();
	// forEach($concerne as $idG){		
		// $num=leGroupe($idG['id_etu']);
		// if (!in_array($num, $groupeLie)) {
			// $groupeLie[]=$num;
		// }					
	// }
	
	//$concerne[0]['id_etu']
	$rep=array();

	//$groupeLie as $j $groupe 
	infoEleve2($_SESSION['profil']['num_grpe'], $eleve[0]); //trouve les infos de élèves d'un groupe
	$nbEleve[0]=nombreEleve2($_SESSION['profil']['num_grpe']);
	$moyenne=0;
	forEach($eleve[0] as $i=>$e){
		
		$mauvaise=0;
		$bonne=0;
		$attendu=0;
		forEach($lesQuestions as $s=> $Q){
			//saRepPourQ($e['id_etu'],$_POST['leTest'], $Q['id_quest'], $sesReponses[$j][$i][]);
			saRepPourQ($e['id_etu'],$id_test, $Q['id_quest'], $liste[]);

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
							
							 $rep[0][$i][]=$o['id_rep'];
						}
						else{
							$rep[0][$i][]="x";
							
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
							 $rep[0][$i][]=$o['id_rep'];
						 }
						 else{
							 $rep[0][$i][]="x";
						}
					}
				}
									
			}
			$liste=array();			
		}
		if($bonne>0){
			$eleve[0][$i]['note']=(($bonne-$mauvaise*0.5)/$attendu)*20;
		}
		else{
			$eleve[0][$i]['note']=0;
		}
		$moyenne+=$eleve[0][$i]['note'];
		
		
	}
			
	$_SESSION['moyGroup'][]=($moyenne/$nbEleve[0]);


	

}

function afficher_résultats() {
	$nom_test = $_SESSION['nom_test'];
	$questions = $_SESSION['questions'];

	require  ("./vue/etudiant/resultatsEtudiant.tpl");
}

function accueil_etudiant() {
	require ('./modele/utilisateurBD.php');
	$num_grp = $_SESSION['profil']['num_grpe'];
	$login = $_SESSION['profil']['nom'];
	connect_BD();
	$_SESSION['tests'] = array();
	appel_test();
	require ("./vue/etudiant/accueilEtudiant.tpl");

}

function deconnect() {
	require ('./modele/utilisateurBD.php');
	deconnect_BD();
	$_SESSION = array();
	session_destroy();
	header('Location: index.php'); //true ou false en base;
}


?>
