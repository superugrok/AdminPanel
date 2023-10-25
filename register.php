<?php
	session_start();
	include_once "functions/user.php";
	include_once "functions/functions.php";

	if(checkAuth($_SESSION['user']) == true) {
		header ("Location: https://evionrp.ru/evi-admin/index.php");
	}

	if(isset($_POST['sendReg'])) {
		if(checkLenLogin($_POST['login']) == true && checkLenPass($_POST['password']) == true && checkLenEmail($_POST['email']) == true && $_POST['password'] == $_POST['password2'] && checkExist($_POST['login'], $_POST['email'], $_POST['code']) == true) {
			$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
			$password = filter_var(trim(password_hash($_POST['password'], PASSWORD_DEFAULT)), FILTER_SANITIZE_STRING);
			$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
			$code = filter_var(trim($_POST['code']), FILTER_SANITIZE_STRING);
			$rang = 'Администратор';
			if(isset($_POST['autoLogin']))
				$autoLogin = true;
			else
				$autoLogin = false;
			User::register($login, $password, $email, $code, $rang, $autoLogin);
			header("Location: https://evionrp.ru/evi-admin/index.php");
		}
		elseif(checkLenLogin($_POST['login']) == false)
			$error = 'Недопустимая длина логина. Минимум символов: 3, максимум: 15.';
		elseif(checkLenPass($_POST['password']) == false)
			$error = 'Недопустимая длина пароля. Минимум символов: 6, максимум: 20.';
		elseif(checkLenEmail($_POST['email']) == false)
			$error = 'Указанный Email некорректен.';
		elseif($_POST['password'] != $_POST['password2'])
			$error = 'Пароли не совпадают.';
		elseif(checkExist($_POST['login'], $_POST['email'], $_POST['code']) == false)
			$error = 'Аккаунт существует или неправильный секретный код!';
	}
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Evion Web Admin</title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>
	<?php if(checkAuth($_SESSION['user']) == false): ?>
	<section class="login">
		<div class="logo_flex"><div class="small_logo"></div><p class="logo_text">EVION</p></div>
		<p class="error_start"><?=$error; ?></p>
		<form action="" method="post">
			<p><input type="text" name="login" placeholder="Ваш логин" class="preInput" required></p>
			<p><input type="text" name="email" placeholder="Ваш E-mail" class="preInput" required></p>
			<p><input type="password" name="password" placeholder="Ваш пароль" class="preInput" onclick="autoShow();" autocomplete="new-password" required></p>
			<p><input type="password" name="password2" placeholder="Повторите пароль" class="preInput" style="display: none;" required></p>
			<p><input type="password" name="code" placeholder="Секретный код доступа" class="preInput" required></p>
			<div class="flex_center">
				<div class="row_flex">
					<span class="remember">
						<input type="checkbox" name="autoLogin">Авто авторизация
					</span>
					<a href="https://evionrp.ru/evi-admin/index.php" class="reg_btn">Авторизация</a>
				</div>
			</div>
			<p><button name="sendReg" type="submit" class="button auth_btn">Зарегистрироваться</button></p>
			<script src="js/register.js"></script>
		</form>
	</section>
	<?php endif; ?>
</html>