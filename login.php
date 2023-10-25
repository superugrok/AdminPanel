<?php
	$btnAuthHash = md5(mt_rand(52, 83500));
	setcookie('a', $btnAuthHash, time() + 86500, "/");
	if(isset($_POST['send2FA'])) {
		$login = $_COOKIE['fa'];
		require "functions/database.php";
		$query = $db->prepare('SELECT * FROM `evi_admin`.`users` WHERE `login` = :login');
		$query->bindParam(':login', $login);
		$query->execute();
		$answer = $query->fetchAll();
		$faKey = $answer[0]['2fa_key'];
		$rang = $answer[0]['rang'];
		$regDate = $answer[0]['reg_date'];
		$lastLogin = $answer[0]['last_login'];
		$email = $answer[0]['email'];
		$ga = new GoogleAuthenticator;
		$code = $ga->getCode($faKey);
		if($code != $_POST['code2FA'])
			$error = 'Неправильный код!';
		else {
			setcookie('f', 1, time() + 0, "/");
			setcookie('fa', 1, time() + 0, "/");
			setcookie('a', 1, time() + 0, "/");
			$user = new User($answer[0]['login'], $email, $rang, $regDate, $lastLogin);
			$user->login(false);
			if(isset($_POST['remember']))
				$user->login(true);
			header("Location: https://evionrp.ru/evi-admin/index.php");
		}
		$db = null;
	}
	if(isset($_POST['sendAuth']) && $_POST['sendAuth'] == $_COOKIE['a']) {
		require "functions/database.php";
		setcookie('f', 1, time() + 86500, "/");
	
		$login = filter_var(trim($_POST["login"]), FILTER_SANITIZE_STRING);
		$password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);

		$getAuth = $db->prepare('SELECT * FROM `evi_admin`.`users` WHERE `login` = :login');
		$getAuth->bindParam(':login', $login);
		$getAuth->execute();
		$answer = $getAuth->fetchAll();
		$getAuth = NULL;
		$rang = $answer[0]['rang'];
		$regDate = $answer[0]['reg_date'];
		$lastLogin = $answer[0]['last_login'];
		$email = $answer[0]['email'];
		$faStatus = $answer[0]['2fa'];

		if(strcasecmp($login, $answer[0]['login']) == 0 && password_verify($password, $answer[0]['password']) == true) {
			if($faStatus == 'true') {
				setcookie('fa', $login, time() + 86500, "/");
				header("Location: https://evionrp.ru/evi-admin/index.php");
				return;
			}
			setcookie('f', 1, time() + 0, "/");
			setcookie('a', 1, time() + 0, "/");
			$user = new User($answer[0]['login'], $email, $rang, $regDate, $lastLogin);
			$user->login(false);
			if(isset($_POST['remember']))
				$user->login(true);
			header("Location: https://evionrp.ru/evi-admin/index.php");
		}
		else {
			$error = 'Неправильный логин или пароль!';
			$currentFail = $_COOKIE['f'];
			$currentFail++;
			setcookie('f', $currentFail, time() + 86500, "/");
		}
		
		$db = NULL;
	}
	elseif(isset($_POST['sendAuth']) && $_POST['sendAuth'] != $_COOKIE['a'])
		$error = 'Хакер!';
?>
<section class="login">
	<div class="logo_flex"><div class="small_logo"></div><p class="logo_text">EVION</p></div>
	<p class="error_start"><?=$error; ?></p>
	<form action="" method="post" name="auth">
		<p><input type="text" name="login" placeholder="Ваш логин" class="preInput" required></p>
		<p><input type="password" name="password" placeholder="Ваш пароль" class="preInput" required></p>
		<div class="flex_center">
			<div class="row_flex">
				<span class="remember">
					<input type="checkbox" name="remember">Запомнить пароль
				</span>
				<a href="https://evionrp.ru/evi-admin/register.php" class="reg_btn">Регистрация</a>
			</div>
		</div>
		<p><button name='sendAuth' type="submit" class="button auth_btn" value="<?=$btnAuthHash;?>">Авторизоваться</button></p>
	</form>
		<?php if($_COOKIE['f'] >= 2): ?>
			<script src="https://www.google.com/recaptcha/api.js" async defer></script>
			<form id="reCaptcha">
				<div style="display: inline-block; margin-left: auto; margin-right: auto; margin-top: 5px;">
					<div class="g-recaptcha" data-sitekey="6Lcnc9wUAAAAAH8bqxnpIHYtXXegejQjNw9FCHaF"></div>
					<button class="btn_small" style="margin-top: 10px;">Проверить</button>
				</div>
			</form>
			<script src="js/login.js"></script>
		<?php endif; ?>
		<?php if($_COOKIE['fa'] != null): ?>
			<form action="" method="post">
				<p style="margin-bottom: 7px;">Введите код из приложения Google</p>
				<p><input type="text" name="code2FA" placeholder="Код Google Authenticator" class="preInput" required></p>
				<div class="row_flex" style="justify-content: unset;">
					<span class="remember" style="padding-top: 17px; margin-right: 10px;">
						<input type="checkbox" name="remember">Запомнить вход
					</span>
					<p><button name='send2FA' style="margin-top: 10px;" type="submit" class="button auth_btn">Отправить</button></p>
				</div>
				<script src="js/fa_auth.js"></script>
			</form>
		<?php endif;?>
</section>