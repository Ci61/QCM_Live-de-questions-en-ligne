
	
<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <title>Profile</title>
		<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
        <link rel="stylesheet" href="./vue/utilisateur/CSS/profile/bootstrap.css">
        <link rel="stylesheet" href="./vue/utilisateur/CSS/profile/profile.css">
		<link href="./vue/utilisateur/CSS/animate.css" rel="stylesheet" type="text/css">
    </head>
    <body>        
        <section class="home_banner_area">
        	<div class="row">	
           		<div class="container block flipInY animated">
           		
	           		<div class="banner_inner d-flex align-items-center">
	           			<div class="container photo">
				        	<img src="./vue/utilisateur/img/student.png" alt="image d'eleve">
				        </div>
						<div class="banner_content">
							<div class="media">
								<div class="media-body">
									<div class="personal_text">
										<h2><?php 
										print_r ($_SESSION['profil']['nom']." ".$_SESSION['profil']['prenom']);echo ('<br/>');
										?></h2>
										<h5><?php print_r ($_SESSION['profil']['email']);echo ('<br/>');?></h5>
													 <?php 
											echo ('<h6>Matricule: <p>');print_r ($_SESSION['profil']['matricule']);echo ('</p></h6><br/>');
											echo ('<h6>Votre Groupe: <p>');print_r ($_SESSION['profil']['num_grpe']);echo ('</p></h6><br/>');
											echo ("<h6>Votre date d'inscription: <p>");print_r ($_SESSION['profil']['date_etu']);echo ('</p></h6><br/>');
										?>

										<div class="return-button"><?php 
											echo('<a href="index.php?controle=etudiant&action=accueil_etudiant"><img src="./vue/utilisateur/img/return.png" alt=""></a>');?>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
            	</div>
	    	</div>
        </section>
        
    </body>
</html>

