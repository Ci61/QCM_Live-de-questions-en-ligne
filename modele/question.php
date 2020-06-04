<?php

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
	select($lesQuestions, $sql);
}
?>