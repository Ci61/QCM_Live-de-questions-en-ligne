	<!--menu-->
	<header id="header_outer">
		<div class="container">
			<div class="header_section">
				<div class="logo"><a href="javascript:void(0)"><img src="./vue/utilisateur/img/prof.png" alt="image prof"></a></div>
				<nav class="nav" id="nav">
					<ul class="toggle">
						<li><?php 
							if($_SESSION['profil']['role']=='prof')
									$url="index.php?controle=prof&action=page_profile";
							else
									$url="index.php?controle=etudiant&action=page_profile";
						?><a href =<?php echo($url);?>>Profil</a></li>
						<li><a href="#service">Services</a></li>
						<li><?php 
								if($_SESSION['profil']['role']=='prof')
									$url="index.php?controle=prof&action=deconnectProf";
								else
									$url="index.php?controle=etudiant&action=deconnect";
						?><a href =<?php echo($url);?>>Deconnect</a></li>
					</ul>
					<ul class="">
						<li><?php 
							if($_SESSION['profil']['role']=='prof')
									$url="index.php?controle=prof&action=page_profile";
							else
									$url="index.php?controle=etudiant&action=page_profile";
						?><a href =<?php echo($url);?>>Profil</a></li>
						<li><a href="#service">Services</a></li>
						<li><?php 
								if($_SESSION['profil']['role']=='prof')
									$url="index.php?controle=prof&action=deconnectProf";
								else
									$url="index.php?controle=etudiant&action=deconnect";
						?><a href =<?php echo($url);?>>Deconnect</a></li>
					</ul>
				</nav>
				<a class="res-nav_click animated wobble wow" href="javascript:void(0)"><i class="fa-bars"></i></a> </div>
		</div>
	</header>
	<!--menu-->
