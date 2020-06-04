<?php 
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
	require ('./modele/utilisateurBD.php');
	$sql="SELECT id_test, titre_test FROM test where id_test=".$id_test." and date_test=curdate()";
	select($testDuJour, $sql);
	
}
?>