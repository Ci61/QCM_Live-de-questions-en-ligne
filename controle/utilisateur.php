<?php 
/*controleur c1.php :
  fonctions-action de gestion (c1)
*/

function ident() {
	$login=  isset($_POST['login'])?($_POST['login']):'';
	$pass=  isset($_POST['pass'])?($_POST['pass']):'';
	$role=isset($_POST['role'])?($_POST['role']):'';
	$msg='';

	if  (count($_POST)==0){
        require ("./vue/utilisateur/ident.tpl") ;
	}
    else {
	    if  (! verif_ident($login,$pass,$role,$profil)) {
			$_SESSION['profil']=array();
	        $msg ="erreur de saisie";
	        require ("./vue/utilisateur/ident.tpl") ;
		}
	    else { 
			if ($role == 'prof'){
				$_SESSION['profil'] = $profil;
				
				$url = "index.php?controle=prof&action=accueilProf";
				
				header ("Location:" .$url) ;
			
			}
			else {
				$_SESSION['profil'] = $profil;
				$url = "index.php?controle=etudiant&action=accueil_etudiant";
				header ("Location:" .$url) ;

			}
		}
    }	
}

function verif_ident($login,$pass,$role,&$profil) {
		require ('./modele/utilisateurBD.php');
		return verif_ident_BD($login,$pass,$role,$profil); //true ou false en base;
}

function page_profile(){
	require ('./modele/utilisateurBD.php');
	require ("./vue/utilisateur/profile_page.tpl");

}



?>
