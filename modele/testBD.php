<?php

//*****fonctions communes

function select(&$tableau, $sql){
	require ("modele/connect.php") ; 
	try {
		$commande = $pdo->prepare($sql);
		$bool = $commande->execute();
		if ($bool) {
			$tableau = $commande->fetchAll(PDO::FETCH_ASSOC); 
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}	
}



function Update_insert($sql){
	require ("modele/connect.php") ; 

	try {
		$commande = $pdo->prepare($sql);
		$bool = $commande->execute();
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); 
	}
}

function uneValeur($valeur,$sql){
	require ("modele/connect.php") ;
	$commande = $pdo->prepare($sql);
	$bool = $commande->execute();
	if ($bool) {
		$chiffre = $commande->fetch(PDO::FETCH_ASSOC); 
		if(!empty($chiffre)){
			$id=$chiffre[$valeur];
		}
		else
			$id=0;
		return($id);
	}
}

//*****fin fonctions communes

function select_test(&$test){
	
	$sql="SELECT id_test, titre_test FROM test where id_prof=".$_SESSION['profil']['id_prof'];
	select($test, $sql);

}



//*****fonctions de séléction

function select_test_du_jour(&$testDuJour){
	
	$sql="SELECT id_test, titre_test FROM test where id_prof=".$_SESSION['profil']['id_prof']." and date_test=curdate()";
	select($testDuJour, $sql);
	
}

function select_theme(&$theme){
	
	$sql="SELECT id_theme,titre_theme FROM theme ";
	select($theme, $sql);

}

function select_Q(&$Q){
	
	$sql="SELECT id_quest, texte FROM question ";
	select($Q, $sql);

}

function select_R(&$R,$Q){
	
	$sql="SELECT DISTINCT id_rep, texte_rep,bValide, r.id_quest FROM question inner join reponse as r on r.id_quest =".$Q." where r.id_quest=".$Q;
	select($R, $sql);

}


function QT($test, &$themo){
	
	$sql="SELECT id_quest,texte from question where id_theme=".$test;
	select($themo, $sql);

}

function nombreEleve($numGroupe){	
	$sql = "SELECT count(id_etu) as total from etudiant where num_grpe =".$numGroupe;
	return uneValeur('total',$sql);
}

function nombreEleveConnect($numGroupe){	
	$sql = "SELECT count(id_etu) as total from etudiant where bConnect=1 and num_grpe =".$numGroupe;
	return uneValeur('total',$sql);
}


function selectQduTest($numQCM, &$lesQuestions){
	$sql="SELECT texte, id_quest from question where id_quest =".$numQCM;
	select($lesQuestions, $sql);
}

function selectQCM($numTest, &$lesQuestions){
	$sql="select id_quest, bAutorise,bBloque,bAnnule from qcm where id_test =".$numTest;
	select($lesQuestions, $sql);

}

function selectMaxQCM(){

	$sql="SELECT max(id_qcm) from qcm";
	return uneValeur('max(id_qcm)',$sql);

}

function infoEleve($idGroupe, &$eleve){
	$sql="select id_etu, nom, prenom from etudiant where num_grpe =".$idGroupe;//:Q";
	select($eleve, $sql);
	
}

function trouverGroupe($test, &$concerne){
	$sql="SELECT DISTINCT id_etu from resultat WHERE id_test=".$test." and date_res=curdate() ";
	select($concerne, $sql); 
}

function leGroupe($etu){

	$sql="SELECT num_grpe from etudiant where id_etu=".$etu;
	return uneValeur('num_grpe', $sql);	
}

//***** fin fonctions de séléction

//*****fonctions d'insertion

function creerNewTest($groupe,$titre){
	require ("modele/connect.php") ;

		$sql="INSERT INTO test (id_prof, num_grpe,titre_test,date_test, bActif) VALUES( ".$_SESSION['profil']['id_prof'].", ". $groupe.", '". $titre."' ,curdate(), 0)" ;
		$commande = $pdo->prepare($sql);
		$bool = $commande->execute();

		$sql="SELECT max(id_test) from test";
		return uneValeur('max(id_test)', $sql);
}





function newQCM($test, $question){

	$id=1+selectMaxQCM();
	$sql="insert into qcm(id_qcm, id_test,id_quest,bAutorise,bBloque,bAnnule) values(".$id.", ".$test.", ".$question.", 0, 1,0)";
	Update_insert($sql);
}




function saRepPourQ($id_etu, $test, $question, &$sesReponses){
	$sql="select id_rep from resultat where date_res=curdate() and id_test=".$test." and id_etu=".$id_etu." and id_quest=".$question ;
	select($sesReponses, $sql);
	if(empty($sesReponses)){
		$sesReponses[0]['id_rep']='x';
	}
	return $sesReponses;
}

function compteurRepGroupe($idTest, $id_quest, $id_rep, &$receveur, $num_grpe){

	$sql="SELECT id_rep, Count(*) as nbChoisi FROM resultat r INNER JOIN etudiant e on e.id_etu = r.id_etu where id_rep=".$id_rep." and id_test=".$idTest." and id_quest=".$id_quest." and date_res= curdate() and e.num_grpe =".$num_grpe."  GROUP BY r.id_rep";

	select($receveur, $sql);
	if(empty($receveur)){
		$receveur=array();
		$receveur[0]['id_rep']=$id_rep;
		$receveur[0]['nbChoisi']=0;
	}
	return $receveur;

}

function compteurRepParQ($id_quest, &$receveur){
	$sql="SELECT count(id_rep) as nb from reponse where id_quest=".$id_quest;
	select($receveur, $sql);
}

function compteurPasDeRepGroupe($idTest, $id_quest, &$receveur, $num_grpe){
	
	$sql="SELECT distinct r.id_etu, COUNT( * ) FROM resultat r INNER JOIN etudiant e on e.id_etu = r.id_etu where id_quest=".$id_quest." and id_test=".$idTest." and date_res= curdate() and e.num_grpe =".$num_grpe."  GROUP BY r.id_etu";
	select($receveur, $sql);
			
}


function compteurRep($idTest,$id_quest, $id_rep, &$receveur){

	$sql="SELECT id_rep, COUNT( * ) FROM resultat r where id_rep=".$id_rep." and id_test=".$idTest."and id_quest=".$id_quest." and date_res= curdate()   GROUP BY r.id_rep";
	select($receveur, $sql);
	if(empty($receveur)){
		$receveur=array();
		$receveur['id_rep']=$id_rep;
		$receveur['COUNT( * )']=0;
	}
		
	return $receveur;

}

function lancerAncienTest($numGroupe, $numTest){

	$sql="UPDATE test set num_grpe=".$numGroupe.", date_test=curdate()  , bActif=1 where id_test=". $numTest ;
	Update_insert($sql);
}

function paramQuestion($idTest, $idQ, $valeur1,  $valeur2, $valeur3){

	$sql="UPDATE qcm set bAutorise=".$valeur1.", bBloque=".$valeur2.", bAnnule=".$valeur3." where id_test=".$idTest." and id_quest=".$idQ ;
	Update_insert($sql);
}

function finirTest($idTest){

	$sql="UPDATE test set bActif=0 where id_test=".$idTest ;
	Update_insert($sql);
}

// Marine
function get_id_theme(&$id_t){
	require ("modele/connect.php");
	$id_t="";
	$sql_theme = "SELECT id_theme FROM theme where titre_theme =:nom_theme";
	$res_theme = array(); 
	
	try {
		$cde_theme = $pdo->prepare($sql_theme);
		$cde_theme->bindParam(':nom_theme', addslashes($_SESSION['créer_question']['theme']));
		$b_theme = $cde_theme->execute();
		
		if ($b_theme) {
			$res_theme = $cde_theme->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("ici"); // On arrête tout.
	}
	
	if (count($res_theme)>0) {
		$id_t = $res_theme[0]['id_theme'];
		return true;
	}	
	return false;
}

// Marine
function get_id_quest(&$id_q){
	require ("modele/connect.php");
	$id_q="";
	$sql_q = "SELECT id_quest FROM question where texte =:texte";
	$res_q = array(); 
	
	try { 
		$cde_q = $pdo->prepare($sql_q);
		$cde_q->bindParam(':texte', $_SESSION['créer_question']['question']);
		$b_q = $cde_q->execute();
		
		if ($b_q) {
			$res_q = $cde_q->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("ici"); // On arrête tout.
	}
	
	if (count($res_q)>0) {
		$id_q=$res_q[0]['id_quest'];
		return true;
	}	
	return false;
}
// Marine
function enregistrer_reps_BD($réponses){
	require ("modele/connect.php") ;
	$sql="SELECT max(id_rep) from reponse";
	$id = uneValeur('max(id_rep)',$sql);
	$id = $id + 1;
	$id_q = "";
	get_id_quest($id_q);
	for ($i = 1; $i <= $_SESSION['créer_question']['nb_rep']; $i++){
		$sql="INSERT INTO reponse (id_rep, id_quest,texte_rep, bvalide) VALUES( ".$id.", ".$id_q.", '".addslashes($réponses[$i]['texte_rep'])."',".$réponses[$i]['bValide'].")" ;
		$commande = $pdo->prepare($sql);
		$bool = $commande->execute();
		$id =$id +1;
	}
	
}
// Marine 
function enregistrer_question_BD(){
	require ("modele/connect.php") ;
	$sql="SELECT max(id_quest) from question";
	$id = uneValeur('max(id_quest)',$sql);
	$id = $id + 1;
	$id_theme = "";
	get_id_theme($id_theme);
	$bmultiple = "";
	if($_SESSION['créer_question']['bmultiple']=="oui"){
		$bmultiple = 1;
	}
	else {
		$bmultiple = 0;
	}
	$sql="INSERT INTO question (id_quest, id_theme,titre,texte,bmultiple) VALUES( ".$id.", ".$id_theme.", '".addslashes($_SESSION['créer_question']['titre'])."','".addslashes($_SESSION['créer_question']['question'])."',".$bmultiple.")" ;
	$commande = $pdo->prepare($sql);
	$bool = $commande->execute();
	
}


function enregistrer_theme_bd($nom_theme, $description_theme){
	require ("modele/connect.php") ;
	$sql="SELECT max(id_theme) from theme";
	$id = uneValeur('max(id_theme)',$sql);
	$id = $id + 1;
	
	$sql="INSERT INTO theme (id_theme, titre_theme,desc_theme) VALUES( ".$id.", '".$nom_theme."', '".addslashes($description_theme)."')" ;
	$commande = $pdo->prepare($sql);
	$bool = $commande->execute();
	
}
?>