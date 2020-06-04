<?php

function avoir_questions_b_BD(&$questions,&$id_test){
	require ("modele/connect.php");
	$sql_b = "SELECT bAutorise,bBloque,bAnnule FROM qcm where id_quest =:id_quest and id_test =:id_test";
	$res_b = array(); 
	$i=0;
	foreach($questions as $q){
		try {
			$cde_b = $pdo->prepare($sql_b);
			$cde_b->bindParam(':id_quest', $q['id_quest']);
			$cde_b->bindParam(':id_test', $id_test);
			$b_b = $cde_b->execute();
			
			if (($b_b)) {
				$res_b = $cde_b->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
		}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
			die("ici"); // On arrête tout.
		}
		if ((count($res_b)> 0)) {
			$questions[$i]['booléens'] = array();
			$questions[$i]['booléens'] = $res_b[0];
		}
		$i = $i+1;
	}
	if (count($res_b)> 0) {

		return true;
	}	
	return false;
}


function avoir_id_quest_BD(&$id_test,&$liste_id_quest){
		require ("modele/connect.php"); 
	$liste_id_quest = array();
	//on doit récupérer les id des questions avant de récupérer les questions que l'on souhaite.
	$sql_id_quest = "SELECT id_quest FROM qcm where id_test =:id_test_e "; //and bAutorise = 0 à faire
	$res_id_quest= array(); 
	
	
	try {
		$cde_id_quest = $pdo->prepare($sql_id_quest);
		$cde_id_quest->bindParam(':id_test_e', $id_test);
		$b_id_quest = $cde_id_quest->execute();
		
		if ($b_id_quest) {
			$res_id_quest = $cde_id_quest ->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("ici"); // On arrête tout.
	}
	
	if (count($res_id_quest)> 0) {
		$liste_id_quest = $res_id_quest;
	}	
//ce qui ne marche pas 
	return false;
	
}
function selectQCM($numTest, &$lesQuestions){
	$sql="select id_quest, bAutorise,bBloque,bAnnule from qcm where id_test =".$numTest;
	select2($lesQuestions, $sql);

}

function avoir_questions_BD(&$liste_id_quest, &$questions){
	require ("modele/connect.php"); 
		$questions = array();
		$sql_quest = "SELECT * FROM question where id_quest =:id_quest_e";
		$res_quest= array(); 
		
		foreach($liste_id_quest as $id_quest){
			try {
				$cde_quest = $pdo->prepare($sql_quest);
				$cde_quest->bindParam(':id_quest_e', $id_quest['id_quest']);
				$b_quest = $cde_quest->execute();
				
				if ($b_quest) {
					//on met dans res_quest chaque question 
					$res_quest = $cde_quest ->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
				}
				if (count($res_quest)> 0 && in_array($res_quest[0],$questions)==false) {
					
					$questions[] = $res_quest[0];
				}
			}
			catch (PDOException $e) {
				echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
				die("ici"); // On arrête tout.
			}
		}
		if (count($questions)>0){
			return true;
		}
		return false;
}

function selectQduTest($numQCM, &$lesQuestions){
	$sql="SELECT texte, id_quest from question where id_quest =".$numQCM;
	select2($lesQuestions, $sql);
}
function avoir_id_test_pour_questions(&$questions){
	require ("modele/connect.php");
	
	$sql_id = "SELECT id_test FROM resultat where id_quest =:id_quest and date_res = CURDATE() and id_etu =:id_etu";
	$res_id = array(); 
	$i = 0;
	foreach($questions as $q){
		try {
			$cde_id = $pdo->prepare($sql_id);
			$cde_id->bindParam(':id_quest', $q['id_quest']);
			$cde_id->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
			$b_id = $cde_id->execute();
			
			if ($b_id) {
				$res_id = $cde_id->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
			if (count($res_id)> 0) {
				$questions[$i]['id_test'] = $res_id[0];
				
			}	
		}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
			die("ici"); // On arrête tout.
		}
		$i = $i + 1;
	}
	
	if (count($res_id)> 0) {
		//$test = $res_id[0];
		return true;
	}	
	return false;	
	
}

function avoir_résultat_id_test_BD(&$resultat,$id_test){
	require ("modele/connect.php"); 
		$sql_res = "SELECT * FROM resultat where date_res=CURDATE() and id_etu =:id_etu and id_test =:id_test";
		$res_rées= array(); 
			try {
				$cde_res = $pdo->prepare($sql_res);
				$cde_res->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
				$cde_res->bindParam(':id_test', $id_test);
				$b_res = $cde_res->execute();
				
				if ($b_res) {
					$res_res = $cde_res ->fetchAll(PDO::FETCH_ASSOC); 
				}
			}
			catch (PDOException $e) {
				echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
				die("ici"); // On arrête tout.
			}
		if (count($res_res)> 0) {
			$resultat = $res_res;
		}
}


function avoir_résultat_BD(&$resultat){
	require ("modele/connect.php"); 
		$sql_res = "SELECT * FROM resultat where date_res=CURDATE() and id_etu =:id_etu";
		$res_rées= array(); 
			try {
				$cde_res = $pdo->prepare($sql_res);
				$cde_res->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
				$b_res = $cde_res->execute();
				
				if ($b_res) {
					$res_res = $cde_res ->fetchAll(PDO::FETCH_ASSOC); 
				}
			}
			catch (PDOException $e) {
				echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
				die("ici"); // On arrête tout.
			}
		if (count($res_res)> 0) {
			$resultat = $res_res;
		}
}

function enregistrer_résultat_BD(){
	require ("modele/connect.php"); 
	//on récupère l'id max. 
	$id_res = 0;
	$sql_id_res = "SELECT MAX(id_res) FROM resultat"; 
	$res_id_res= array(); 
	
	
	try {
		$cde_id_res = $pdo->prepare($sql_id_res);
		$b_id_res = $cde_id_res->execute();
		
		if ($b_id_res) {
			$res_id_res = $cde_id_res ->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("ici"); // On arrête tout.
	}
	
	if (count($res_id_res)>0){
		$id_res = (int)($res_id_res[0]['MAX(id_res)']);
		$id_res = $id_res + 1; //on l'incrémente pour pouvoir l'utiliser ensuite
	}
	else {
		$id_res = 0;
	}
	
	foreach($_SESSION['questions'] as $quest){
	//	var_dump($quest);
			try {
				$sql_res = "INSERT INTO resultat (id_res,id_test,id_etu,id_quest,date_res,id_rep) VALUES (:id_res,:id_test,:id_etu,:id_quest,CURDATE(),:id_rep)";
				if (($quest['booléens']['bBloque']==false)&&($quest['booléens']['bAnnule']==false)&&($quest['b_repondu']==false)){
					if ($quest['bmultiple']==false){
						if(existe_resultat_BD($_SESSION['id_test'], $quest['id_quest'],$_SESSION['profil']['id_etu'],$quest['resultat'])==false){
							$cde_res = $pdo->prepare($sql_res);
							$cde_res->bindParam(':id_res', $id_res);
							$cde_res->bindParam(':id_test', $_SESSION['id_test']);
							$cde_res->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
							$cde_res->bindParam(':id_quest', $quest['id_quest']);
							$cde_res->bindParam(':id_rep', $quest['resultat']);
							$b_res = $cde_res->execute();

							$id_res = $id_res + 1;
						}

					
					}
					else if ($quest['bmultiple']==true && isset($quest ['resultat'])){
						foreach($quest ['resultat']as $id_rep){
							if(existe_resultat_BD($_SESSION['id_test'], $quest['id_quest'],$_SESSION['profil']['id_etu'],$id_rep)==false){
								$cde_res = $pdo->prepare($sql_res);
								$cde_res->bindParam(':id_res', $id_res);
								$cde_res->bindParam(':id_test', $_SESSION['id_test']);
								$cde_res->bindParam(':id_etu', $_SESSION['profil']['id_etu']);
								$cde_res->bindParam(':id_quest', $quest['id_quest']);
								$cde_res->bindParam(':id_rep', $id_rep);	
								$b_res = $cde_res->execute();

								$id_res = $id_res + 1;
							}
						}
					}
				}
				
			}
			catch (PDOException $e) {
				echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
				die("ici"); // On arrête tout.
			}
	}	
	
}
function saRepPourQ($id_etu, $test, $question, &$sesReponses){

	$sql="select id_rep from resultat where date_res=curdate() and id_test=".$test." and id_etu=".$id_etu." and id_quest=".$question ;
	select2($sesReponses, $sql);
	if(empty($sesReponses)){
		$sesReponses[0]['id_rep']='x';
	}
	return $sesReponses;
}

//si il existe déjà un résultat
function existe_resultat_BD($id_test, $id_quest,$id_etu,$id_rep){
	require ("modele/connect.php");
	$sql_ex = "SELECT * FROM resultat WHERE id_test =:id_test and id_quest=:id_quest and id_etu=:id_etu and date_res=CURDATE() and id_rep=:id_rep";
	$res_ex= array(); 
	try {
		$cde_ex = $pdo->prepare($sql_ex);
		$cde_ex->bindParam(':id_rep', $id_rep);
		$cde_ex->bindParam(':id_test', $id_test);
		$cde_ex->bindParam(':id_etu', $id_etu);
		$cde_ex->bindParam(':id_quest', $id_quest);
		$b_ex = $cde_ex->execute();
		
		if ($b_ex) {
			$res_ex = $cde_ex ->fetchAll(PDO::FETCH_ASSOC); 
		}

	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("existe_resultat_BD"); // On arrête tout.
	}
	if (count($res_ex)> 0) {
		return true;
	}
	return false;
}

function trouver_etudiants_groupe($test, &$concerne){
	$sql="SELECT DISTINCT r.id_etu FROM resultat r INNER JOIN etudiant e on e.id_etu = r.id_etu WHERE r.id_test=".$test." and r.date_res=curdate() and e.num_grpe =".$_SESSION['profil']['num_grpe']."";
	select2($concerne, $sql); 
}

function avoir_liste_tests_BD(&$num_grp,&$tests){
	require ("modele/connect.php"); 
	$tests= array();
	$sql_tests = "SELECT * FROM test where num_grpe =:num_grpe_e and bActif = true"; 
	$res_tests= array(); 
	
	try {
		$cde_tests = $pdo->prepare($sql_tests);
		$cde_tests->bindParam(':num_grpe_e', $num_grp);
		$b_tests = $cde_tests->execute();
		
		if ($b_tests) {
			$res_tests = $cde_tests->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
	
	if (count($res_tests)> 0) {
		$tests = $res_tests;
		return true;
	}	
	else {
		$tests = "il n'y a pas de tests disponibles";
	}
	return false;
}

//on récupère le test à partir du nom
function avoir_test_nom_BD($nom_test,&$test){
	require ("modele/connect.php");
	$test = array();
	$sql_test = "SELECT * FROM test where titre_test =:nom_test";
	$res_test = array(); 
	
	try {
		$cde_test = $pdo->prepare($sql_test);
		$cde_test->bindParam(':nom_test', $nom_test);
		$b_test = $cde_test->execute();
		
		if ($b_test) {
			$res_test = $cde_test->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
		}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die("ici"); // On arrête tout.
	}
	
	if (count($res_test)> 0) {
		$test = $res_test[0];
		return true;
	}	
	return false;
}


//on récupère le test à partir de l'id
function avoir_test_id_BD(&$liste_id_test,&$test){
	require ("modele/connect.php");
	$test = array();
	$sql_test = "SELECT * FROM test where id_test =:id_test";
	$res_test = array(); 
	
	foreach($liste_id_test as $id_test){
		try {
			$cde_test = $pdo->prepare($sql_test);
			$cde_test->bindParam(':id_test', $id_test);
			$b_test = $cde_test->execute();
			
			if (($b_test)) {
				$res_test = $cde_test->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
		}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
			die("ici"); // On arrête tout.
		}
		if ((count($res_test)> 0)&& (in_array($res_test[0],$test)==false)) {
			$test[] = $res_test[0];
		}
	}
	if (count($test)> 0) {

		return true;
	}	
	return false;
}

function select_test_du_jour(&$testDuJour,$id_test){
	// require ('./modele/utilisateurBD.php');
	// require ('./modele/utilisateurBD.php');
	$sql="SELECT id_test, titre_test FROM test where id_test=".$id_test." and date_test=curdate()";
	select2($testDuJour, $sql);
	
}
function avoir_réponses_BD (&$questions){
	require ("modele/connect.php"); 

		$sql_rép = "SELECT * FROM reponse where id_quest =:id_quest_e";
		$res_rép= array(); 
		$i = 0;
		foreach($questions as $quest){
			try {
				$cde_rép = $pdo->prepare($sql_rép);
				$cde_rép->bindParam(':id_quest_e', $quest['id_quest']);
				$b_rép = $cde_rép->execute();
				
				if ($b_rép) {
					//on met dans res_quest chaque question 
					$res_rép = $cde_rép ->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
				}
				
				if (count($res_rép)> 0) {
					$questions[$i]['réponses'] = $res_rép;
				}
			}
			catch (PDOException $e) {
				echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
				die("ici"); // On arrête tout.
			}
			$i=$i+1;
		}
}

function select_R(&$R,$Q){
	$sql="SELECT DISTINCT id_rep, texte_rep,bValide, r.id_quest FROM question inner join reponse as r on r.id_quest =".$Q." where r.id_quest=".$Q;
	select2($R, $sql);

}

function select2(&$tableau, $sql){
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

function infoEleve2($idGroupe, &$eleve){
	$sql="select id_etu, nom, prenom from etudiant where num_grpe =".$idGroupe;//:Q";
	select2($eleve, $sql);
	
}
function nombreEleve2($numGroupe){	
	$sql = "SELECT count(id_etu) as total from etudiant where num_grpe =".$numGroupe;
	return uneValeur2('total',$sql);
}

function uneValeur2($valeur,$sql){
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


?>