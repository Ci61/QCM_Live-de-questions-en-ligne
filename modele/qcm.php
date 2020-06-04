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
	select($lesQuestions, $sql);

}


?>