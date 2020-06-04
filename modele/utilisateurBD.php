<?php 
/*Fonctions-modèle réalisant la gestion d'une table de la base,
** ou par extension gérant un ensemble de tables. 
** Les appels à ces fcts se fp,t dans c1.
*/

	//echo ("Penser à modifier les paramètres de connect.php avant l'inclusion du fichier <br/>");
	//require ("modele/connect.php") ; //connexion MYSQL et sélection de la base, $link défini
	
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

function verif_ident_BD($login,$pass,$role,&$profil){ 
		require ("modele/connect.php"); 
		$profil = array();
		//global $pdo;
	$sql_etu="SELECT * FROM etudiant where login_etu=:login_e and pass_etu=:pass_e";
	//$sql="SELECT * FROM etudiant where login_etu=:login";
	$res_etu= array(); 
	$sql_prof="SELECT * FROM professeur where login_prof=:login_p and pass_prof=:pass_p";
	$res_prof= array(); 
	try {
		$cde_etu = $pdo->prepare($sql_etu);
		$cde_etu->bindParam(':login_e', $login);
		$cde_etu->bindParam(':pass_e', $pass);
		$b_etu = $cde_etu->execute();
		
		$cde_prof = $pdo->prepare($sql_prof);
		$cde_prof->bindParam(':login_p', $login);
		$cde_prof->bindParam(':pass_p', $pass);
		$b_prof = $cde_prof->execute();
		
		if (($b_etu)&&($b_prof)) {
			$res_etu = $cde_etu->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			$res_prof= $cde_prof->fetchAll(PDO::FETCH_ASSOC); //tableau d'enregistrements
			}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
	

	if ((count($res_etu)> 0) && (count($res_prof)== 0) && $role=="eleve") {
		$profil = $res_etu[0];
		$profil['role']=$role;
		return true;
	}	
	if ((count($res_prof)> 0) && (count($res_etu)== 0) && $role=="prof"){
		$profil = $res_prof[0];
		$profil['role']=$role;		
		return true;
	}
		
		return false;
	//faire une  requête SQL 
}

function connectProf($nom){

	$sql='UPDATE professeur SET bConnect = 1 where nom="'.$nom.'"';
	Update_insert($sql);
}

function disconnectProf($nom){

	$sql='UPDATE professeur SET bConnect = 0 where nom="'.$nom.'"';
	Update_insert($sql);
}


function connect_BD(){
	require ("modele/connect.php"); 
	$sql = "UPDATE etudiant SET bConnect=1 WHERE id_etu=".$_SESSION['profil']['id_etu'];
	Update_insert($sql);
}

function deconnect_BD(){
	require ("modele/connect.php"); 
	$sql = "UPDATE etudiant SET bConnect=0 WHERE id_etu=".$_SESSION['profil']['id_etu'];
	Update_insert($sql);
}

function select_group(&$lesGroupes){
	require ("modele/connect.php") ; 
	
	$sql="SELECT num_grpe FROM groupe "; 
	try {
	$sql = $pdo->prepare($sql);	
		$bool = $sql->execute();
		if ($bool) {
					$lesGroupes = $sql->fetchAll(PDO::FETCH_ASSOC);
					return $lesGroupes;
				}
	}
	catch (PDOException $e) {
		echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
}
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

function infoEleve($idGroupe, &$eleve){
	$sql="select id_etu, nom, prenom from etudiant where num_grpe =".$idGroupe;//:Q";
	select($eleve, $sql);
	
}
function nombreEleve($numGroupe){	
	$sql = "SELECT count(id_etu) as total from etudiant where num_grpe =".$numGroupe;
	return uneValeur('total',$sql);
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








?>