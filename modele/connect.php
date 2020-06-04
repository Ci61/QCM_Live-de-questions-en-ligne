<?php
		

	$hostname = /*"localhost";*/"localhost";
	$base= "pweb19_jin";//"nouvelle_base";
	$loginBD= /*"root";// */"pweb19_jin";
	$passBD=/*"";//*/"x04092000";
	//$pdo = null;

try {


	$pdo = new PDO ("mysql:server=$hostname; dbname=$base; charset=utf8", "$loginBD", "$passBD");
}

catch (PDOException $e) {
	die  ("Echec de connexion : " . utf8_encode($e->getMessage()) . "\n");
}

?>