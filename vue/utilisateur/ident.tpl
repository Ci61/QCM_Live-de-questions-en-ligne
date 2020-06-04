<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="ie" lang="en">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="pc chrome77 js">
<!--<![endif]-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <title>Identification</title>
	<link rel="icon" href="./vue/utilisateur/img/toto.png" type="image/png">
    <link rel="stylesheet" href=".\vue\utilisateur\CSS\ident.css">
</head>
<body>
    <div class="container">
        <img src=".\vue\utilisateur\img\bc.png" alt="">
        <div class="panel">
            <div class="content login">
                <div class="switch">
                    <span id='login'  class='active'>Connexion</span>
                </div>
                <form action="index.php?controle=utilisateur&action=ident" method="post">
                    <div class="input" placeholder='Username'><input name="login"  type="text"></div>
                    <div class="input" placeholder='Password'><input name="pass" type="password"></div>
					<fieldset>
					<div class="toggle">
						<input type="radio" name="role" value="prof" id="prof" checked="checked">
						<label for="prof">Professeur</label>
						<input type="radio" name="role" value="eleve" id="eleve">
						<label for="eleve">Etudiant</label>
					</div>
					</fieldset>
					<div id ="message"> 
						<?php 
						$o= "<p style='color : red;'> %s </p>";
						printf($o,$msg);
						?>
					</div> 
                    <button type ="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script>
    $('#etu').click(function(){
        $('.switch span').removeClass('active');
        $(this).addClass('active');

        $(this).parents('.content').removeClass('signup');
        $(this).parents('.content').addClass('login');

        $('form button').text('LOGIN')
		
    })
	$('#prof').click(function(){
        $('.switch span').removeClass('active');
        $(this).addClass('active');

        $(this).parents('.content').removeClass('signup');
        $(this).parents('.content').addClass('login');

        $('form button').text('LOGIN')

    })

    $('.input input').on('focus',function(){
        $(this).parent().addClass('focus');
    })

    $('.input input').on('blur',function(){
        if($(this).val() === '')
            $(this).parent().removeClass('focus');
    })
</script>
</html>