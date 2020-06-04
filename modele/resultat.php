<?php 
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
	select($sesReponses, $sql);
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
	select($concerne, $sql); 
}


?>