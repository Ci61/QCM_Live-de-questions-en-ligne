<?php

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
	select($R, $sql);

}

?>