<?php
require_once(APP . "view/authorization/auth_header.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Сеть быстрого питания Delivery</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?=URL?>css/styles.css">
		<link rel="icon" href="<?=URL;?>/img/logo.ico">
		<link rel="stylesheet" type="text/css" href="<?=URL?>css/authorization.css">
		<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
	</head>

	<body>
		<div class="login-main">
			<img src="<?=URL?>img/logo.png" alt="logo">
			<div class="login-title">Авторизация</div>
			<input type="text" name="login" placeholder="Логин">
			<input type="password" name="password" placeholder="Пароль">
			<button id="loginButton">
				Авторизация
			</button>
			<!--<a class="login-link-refresh" href="/">Восстановить пароль</a>-->
			<a class="login-link-refresh" href='<?php echo URL; ?>authorization/registration'>Зарегистрироваться</a>
		</div>
		<div class="block_alert">
	    </div>
	    <div class="block_hidden_alert">
	    	<div class="alert error loginMiss">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Вы не указали логин!
	    	</div>
	    	
	    	<div class="alert error passwordMiss">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Вы не указали пароль!
	    	</div>
	    	
	    	<div class="alert error uncorrectUserData">
				<span class="closebtn">&times;</span>
	    		<strong>Ошибка!</strong> Неправильный логин или пароль!
	    	</div>

	    	<div class="alert success">
				<span class="closebtn">&times;</span>
	    		<strong>Успех!</strong>
	    	</div>
	    	
	    </div>
	    <script>
	     let url = '<?= URL; ?>';
	    </script>
	    <script type="text/javascript" src="<?=URL?>js/authorization/login.js"></script>
	    <script type="text/javascript" src="<?=URL?>js/_template_scripts/alert.js"></script>
	    <script type="text/javascript" src="<?=URL?>js/_template_scripts/helper.js"></script>
	</body>
</html>