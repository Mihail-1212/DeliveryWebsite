<?php
require_once(APP . "view/authorization/auth_header.php");
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>Сеть быстрого питания Delivery</title>
		<meta charset="utf-8">
		<link rel="icon" href="<?=URL;?>/img/logo.ico">
		<link rel="stylesheet" type="text/css" href="<?=URL?>css/styles.css">
		<link rel="stylesheet" type="text/css" href="<?=URL?>css/authorization.css">
		<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
		<title>Reg form</title>
	</head>

	<body>
		<div class="login-main">
			<img src="<?=URL?>img/logo.png" alt="logo">
			<div class="login-title">Регистрация</div>
		
			<input type="text" name="login" placeholder="Логин" >
			<input type="password" name="password" placeholder="Пароль">
			<input type="password" name="password_repeat" placeholder="Подтверждение пароля">
			<button id="registrationButton">
				Регистрация
			</button>
			<a class="login-link-refresh" href='<?php echo URL; ?>authorization/login'>Авторизоваться</a>
		</div>
		<div class="block_alert">
	    </div>
	    <div class="block_hidden_alert">
	    	<div class="alert error loginMiss">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Ошибка при вводе логина!
	    	</div>
	    	
	    	<div class="alert error passwordMiss">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Ошибка при вводе пароля!
	    	</div>
	    	
	    	<div class="alert error differentPasswords">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Пароли различаются!
	    	</div>
	    	
	    	<div class="alert error existLogin">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Данный логин уже существует в системе!
	    	</div>
	    	
	    	<div class="alert error shortUserDatas">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Ошибка при вводе логина или пароля! Длина логина и пароля должны быть не менее 8 символов!
	    	</div>

	    	<div class="alert success">
				<span class="closebtn">&times;</span>
	    		<strong>Успех!</strong>
	    	</div>
	    	
	    </div>
	    <script>
            let url = '<?= URL; ?>';
    	</script>
    	<script type="text/javascript" src="<?=URL?>js/authorization/registration.js"></script>
    	<script type="text/javascript" src="<?=URL?>js/_template_scripts/alert.js"></script>
        <script type="text/javascript" src="<?=URL?>js/_template_scripts/helper.js"></script>
	</body>
</html>