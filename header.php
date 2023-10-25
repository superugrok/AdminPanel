<?php
	session_start();
	require_once "functions/functions.php";
	require_once "functions/user.php";
	require_once "functions/GoogleAuthenticator.php";
	$userLastLogin = getdate($_SESSION['user']['lastLogin']);

	# Проверка 2fa
	require "functions/database.php";
	$query = $db->prepare('SELECT `2fa` FROM `evi_admin`.`users` WHERE `login` = :login');
	$query->bindParam(':login', $_SESSION['user']['login']);
	$query->execute();
	$answerFa = $query->fetchAll();
	$db = null;
	# Выход (уничтожение сессии)
	if(isset($_POST['exit'])) {
		setcookie('user', '0', time() + 0, "/");
		session_destroy();
		header("Location: https://evionrp.ru/evi-admin/index.php");
	}
	# Включение 2fa
	if(isset($_POST['2fa_on'])) {
		require "functions/database.php";
		$login = $_SESSION['user']['login'];
		$ga = new GoogleAuthenticator;
		$privKey = $ga->generateSecret();
		$query = $db->prepare('UPDATE `evi_admin`.`users` SET `2fa_key` = :privKey WHERE `login` = :login');
		$query->bindParam(':privKey', $privKey);
		$query->bindParam(':login', $login);
		$query->execute();
		$db = null;
		header("Location: https://evionrp.ru/evi-admin/2fa.php");
	}
	# Выключение 2fa
	if(isset($_POST['2fa_off'])) {
		require "functions/database.php";
		$login = $_SESSION['user']['login'];
		$query = $db->prepare('UPDATE `evi_admin`.`users` SET `2fa` = :status WHERE `login` = :login');
		$faStatus = NULL;
		$query->bindParam(':status', $faStatus);
		$query->bindParam(':login', $login);
		$query->execute();
		$query = $db->prepare('UPDATE `evi_admin`.`users` SET `2fa_key` = :privKey WHERE `login` = :login');
		$privKey = NULL;
		$query->bindParam(':privKey', $privKey);
		$query->bindParam(':login', $login);
		$query->execute();
		$db = null;
	}
	# Получение аватара
	require "functions/database.php";
	$query = $db->prepare('SELECT `avatar` FROM `evi_admin`.`users` WHERE `login` = :login');
	$query->bindParam(':login', $_SESSION['user']['login']);
	$query->execute();
	$avatar = $query->fetchAll();
	$ver = '?='.mt_rand(1000, 1000000);
	$db = null;
	# Загрузка аватара
	if(isset($_FILES['file'])) {
		$fileName = $_FILES['file']['name'];
		$fileSize = $_FILES['file']['size'];
		$fileTmp = $_FILES['file']['tmp_name'];
		$fileType = $_FILES['file']['type'];
		$avatarType = substr($fileType, strpos($fileType, '/') + 1);
		$fileError = $_FILES['file']['error'];
		$uploadDir = '/var/www/evionrp.ru/evi-admin/assets/avatars/';
		$userName = $_SESSION['user']['login'].".".$avatarType;
		if($fileSize <= 2048 && $fileError == 0 && $avatarType == 'jpeg' || $avatarType == 'jpg' || $avatarType == 'png') {
			move_uploaded_file($fileTmp, $uploadDir.$userName);
			$image = new SimpleImage();
			$image->load('assets/avatars/'.$userName);
			$image->resize(72, 72);
			$image->save('assets/avatars/'.$userName);
			$userAvatar = 'https://evionrp.ru/evi-admin/assets/avatars/'.$userName;
			require "functions/database.php";
			$query = $db->prepare('UPDATE `evi_admin`.`users` SET `avatar` = :avatar WHERE `login` = :login');
			$query->bindParam(':avatar', $userAvatar);
			$query->bindParam(':login', $_SESSION['user']['login']);
			$query->execute();
			$db = null;
			header("Location: https://evionrp.ru/evi-admin");
		}
		else
			$avatarError = 'Изображение некорректно.';
	}
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Evion Web Admin - <?=$page;?></title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
		<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>
	<body onload="menuActive(); checkAvatarErrors();">
		<?php if(checkAuth($_SESSION['user']) == false): ?>
			<?php include_once "login.php"; ?>
		<?php endif; ?>
		<?php if(checkAuth($_SESSION['user']) == true): ?>
		<header>
			<div class="menu_btn" onclick="menuSwitch();"></div>
			<div class="logo"></div>
			<div class="user_profile">
				<div class="mini_profile" onclick="profileSwitch();">
					<p style="font-weight: bold; font-size: 0.8rem"><?=$_SESSION['user']['login'];?></p>
					<p>Последний вход: <b><?=$userLastLogin['mday'].".".$userLastLogin['mon'].".".$userLastLogin['year'];?></b></p>
				</div>
				<div class="avatar" onclick="profileSwitch();" style="background-image: url('<?=$avatar[0]['avatar'].$ver;?>');"></div>
				<div class="user_bar">
					<p class="user_header">Изменить фото профиля</p>
					<form action="" method="post" enctype="multipart/form-data">
						<p class="text_error" name="avatarError"><?=$avatarError;?></p>
						<div class="user_row_flex">
							<input type="file" class="inputfile" name="file" id="file" data-multiple-caption="{count} шт. выбрано" multiple>
							<label for="file"><span>Выбрать</span></label>
							<script src="js/file_stab.js"></script>
							<button name="avatar_save" class="user_btn">Сохранить</button>
						</div>
					</form>
					<p class="user_header">Изменить Email</p>
					<p class="text_success" name="email_send">На Ваш старый Email был отправлен код</p>
					<p class="text_success" name="email_changed">Ваш Email изменён!</p>
					<p class="text_error" name="invalid_email_code">Неправильный код!</p>
					<div class="user_email_row_flex">
						<input type="email" class="user_input" placeholder="Введите новый Email" name="new_email" id="new_email">
						<input type="text" class="user_input" placeholder="Введите код" name="code_email" id="code_email" style="display: none;">
						<button name="email_save" class="btn_ok" onclick="validEmail(document.getElementById('new_email').value, '<?=$_SESSION['user']['email'];?>');"></button>
						<button name="email_code" class="btn_ok" onclick="newEmailCode(document.getElementById('code_email').value, document.getElementById('new_email').value, '<?=$_SESSION['user']['login'];?>');" style="display: none;"></button>
					</div>
					<p class="user_header">Изменить пароль</p>
					<p class="text_success" name="password_send">На ваш Email был отправлен код</p>
					<p class="text_success" name="password_changed">Ваш пароль изменён!</p>
					<p class="text_error" name="invalid_password_old">Неправильный старый пароль!</p>
					<p class="text_error" name="invalid_password_code">Неправильный код!</p>
					<input type="password" name="oldPass" id="oldPass" class="user_input" placeholder="Старый пароль">
					<input type="password" name="newPass" id="newPass" class="user_input btn_margin_top" placeholder="Новый пароль">
					<input type="text" class="user_input" placeholder="Введите код" name="code_password" id="code_password" style="display: none;">
					<button name="pass_save" class="user_btn btn_margin_top" onclick="validPassword(document.getElementById('oldPass').value, document.getElementById('newPass').value, '<?=$_SESSION['user']['email']?>', '<?=$_SESSION['user']['login']?>');">Сохранить</button>
					<button name="pass_save_code" class="user_btn btn_margin_top" onclick="newPasswordCode(document.getElementById('code_password').value, '<?=$_SESSION['user']['login']?>', document.getElementById('newPass').value);" style="display: none;">Отправить</button>
					<p class="user_header">Двухфакторная авторизация</p>
						<form action="" method="post">
							<div class="user_row_flex btn_margin_bot">
								<?php if($answerFa[0]['2fa'] == NULL): ?>
									<button name="2fa_on" class="user_btn">Включить</button>
								<?php endif;?>
								<?php if($answerFa[0]['2fa'] == 'true'): ?>
									<button name="2fa_off" class="user_btn">Выключить</button>
								<?php endif;?>
								<button name="exit" class="user_btn">Выход</button>
							</div>
						</form>
				</div>
			</div>
		</header>
		<nav class="menu">
			<div class="menu_right_main"></div><div class="menu_main"></div><p><a href="https://evionrp.ru/evi-admin/index.php">Главная страница</a></p>
			<div class="menu_right_players"></div><div class="menu_players"></div><p><a href="https://evionrp.ru/evi-admin/players.php">Управление игроками</a></p>
			<div class="menu_right_service"></div><div class="menu_service"></div><p><a href="https://evionrp.ru/evi-admin/services.php">Управление сервисами</a></p>
			<div class="menu_right_server"></div><div class="menu_server"></div><p><a href="https://evionrp.ru/evi-admin/server.php">Управление сервером</a></p>
			<?php if($_SESSION['user']['rang'] == 'Руководитель'): ?>
			<div class="menu_right_access"></div><div class="menu_access"></div><p><a href="https://evionrp.ru/evi-admin/access.php">Контроль доступа</a></p>
			<?php endif; ?>
		</nav>
		<script src="js/header.js"></script>
		<?php endif; ?>