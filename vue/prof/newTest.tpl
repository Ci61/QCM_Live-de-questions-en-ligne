



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Test</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form2.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/test_form1.css">
	<link rel="stylesheet" type="text/css" href="./vue/utilisateur/CSS/radio.css">
</head>

<body>
	<div class="container-contact3">
	<div class="wrap-contact3">
		<form method="post" name="testeur" action="#" >
			<div class='contact3-form-title'><h1 class=' mb-2 text-gray-800'>Mettre un filtre</h1></div>
				<?php 
					if (count($theme) != 0) {
			
						foreach ($theme as $i =>$th) {
							
							$num = $i;
							$id = 'theme' . sprintf('%d', $num);
				?>
						<input type="checkbox" name="themes[<?php echo $num; ?>]" value="<?php echo $th['id_theme'] ?> "
							<?php if(isset($_POST['themes'][$num])){echo(" checked");}
									else{echo("");}
							?>
						id="<?php echo $th['id_theme']; ?>">
						<label for="<?php echo $th['id_theme']; ?>"><?php echo $th['titre_theme']; ?></label>
				<?php
						}
					}
					 else 
						echo ('</br>pas de theme dans la base');
				?>

			
			<?php if(!empty($_POST['themes'])){
				if(count($themo) != 0){
			
			?>	
			<fieldset>
				<legend>Sélectionnez des questions</legend>
				<?php
				foreach ($themo as $i=>$theme) {
					$num = $i;
					$id = 'question' . sprintf('%d', $num);
					foreach($theme as $j=>$question) {
				?>
				
						<input type="checkbox" name="themo[<?php echo $question['id_quest']; ?>]" value="<?php echo $question['id_quest']; ?>" 
						<?php
						if(isset($_POST['themo'][$question['id_quest']])){
							echo(" checked");
						}
						else{
							echo("");
						}
						?>
						id="<?php echo $question['id_quest']; ?>">
		
	
						<label for="<?php echo $id; ?>"><?php echo $question['texte']; ?> </label>
			<?php
					}

				}
				
				}
				else{
					echo("Pas de question pour ce thème.");
				}	
?>
</fieldset>
<?php				
			}
			
			?>
<?php if(!empty($_POST['themes'])){		?>	
			<fieldset>
			<label for="name">Entrez le nom du test :</label>
				<input type="text" id="name" name="name" pattern="[a-zA-Z]{2,29}" placeholder="Veuillez saisir des lettres" minlength=2 maxlength=30 size="30"/>
					
			</fieldset>
<?php }?>
		 <?php //echo (isset($_POST['themes'][$num])?"checked='checked'":""); ?>
			
			<div class="row">




			<input type="submit" name="submit" value="Voir les questions" />
			<?php if(isset($_POST['themes'])){
				echo('<input type="submit" name="submit" value="Créer" /> ');
			}

			?>
			<input type="submit" name="submit" value="Abandonner" /></div>
			

		</form>
	</div>
</div>

			<!-- <div data-toggle="buttons" class="btn-group">
			  <label class="btn btn-default">
			      <input type="checkbox" id="checkbox_custom" name="checkbox">
			      <h5>Confirm Order</h5>
			  </label>
			</div> -->

 </body>

 <!-- <script type="text/javascript">
 	
 	$("#checkbox_custom").on('change', function(){
  var checked = $(this)[0].checked;
  if(checked)
    $('label').addClass("btn-success").removeClass("btn-default");
  else 
    $('label').addClass("btn-default").removeClass("btn-success");
});
 </script> -->
 </html>