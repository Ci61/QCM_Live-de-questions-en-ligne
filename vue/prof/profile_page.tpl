
	
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
				        	<img src="./vue/utilisateur/img/teacher.png" alt="image de prof">
				        </div>
						<div class="banner_content">
							<div class="media">
								<div class="media-body">
									<div class="personal_text">
										<h2><?php 
										print_r ($_SESSION['profil']['nom']." ".$_SESSION['profil']['prenom']);echo ('<br/>');
										?></h2>
										<h5>Votre mail : </h5><?php print_r ($_SESSION['profil']['email']);?></br>
										<h5>Votre date d'inscription : </h5>			 <?php 
										
										
											print_r ($_SESSION['profil']['date_prof']);echo ('<br/>');
										
										?>

									<div class="return-button"><?php 
									if ($_SESSION['profil']['role'] == 'prof'){
										echo('<a href="index.php?controle=prof&action=accueilProf"><img src="./vue/utilisateur/img/return.png" alt=""></a>');
									}
									else {
										echo('<a href="index.php?controle=etudiant&action=accueil_etudiant"><img src="./vue/utilisateur/img/return.png" alt=""></a>');
									}
								?>
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

