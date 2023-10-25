<?php 
	$page = 'Активация 2FA';
	include_once "header.php";

	# 2FA
	$login = $_SESSION['user']['login'];
	require "functions/database.php";
	$query = $db->prepare('SELECT `2fa_key` FROM `evi_admin`.`users` WHERE `login` = :login');
	$query->bindParam(':login', $login);
	$query->execute();
	$answer = $query->fetchAll();
	$query = $db->prepare('SELECT `2fa` FROM `evi_admin`.`users` WHERE `login` = :login');
	$query->bindParam(':login', $login);
	$query->execute();
	$answerStatus = $query->fetchAll();
	$db = null;
	$ga = new GoogleAuthenticator;
	$picture = 'https://www.google.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/'.$login.'@evionrp.ru/evi-admin?secret='.$answer[0]["2fa_key"];

	if(isset($_POST['submit_2fa'])) {
		$code = $ga->getCode($answer[0]['2fa_key']);
		if ($code != $_POST['2fa_code']) 
			$error = 'Неправильный код!';
		else {
			require "functions/database.php";
			$query = $db->prepare('UPDATE `evi_admin`.`users` SET `2fa` = :status WHERE `login` = :login');
			$status = 'true';
			$query->bindParam(':status', $status);
			$query->bindParam(':login', $login);
			$query->execute();
			$db = null;
			$error = 'Подключено! Перезагрузите страницу.';
			header("Location: https://evionrp.ru/evi-admin/index.php");
		}
	}
?>
<?php if(checkAuth($_SESSION['user']) == true && $answer[0]['2fa_key'] != null && $answerStatus[0]['2fa'] != 'true'): ?>
	<link rel="stylesheet" href="css/2fa.css">
		<aside class="twofa">
			<div class="fa_block">
				<h1>Двухфакторная авторизация подключена!</h1>
				<h2>Осталось несколько шагов..</h2>
				<div class="two_flex">
					<p>Подключите приложение через QR код:</p>
					<img name="fa_qr" src='<?=$picture;?>'>
					<a href='<?=$picture;?>'><button type="button" class="button" name="getPicture" style="display: none; width: 20%;">Получить</button></a>
					<script>
							let img = document.createElement('img');
							img.src = '<?=$picture;?>';
							
							img.onload = function() {
							  $('img[name="fa_qr"]').show();
							};
					
							img.onerror = function() {
								let goQR = confirm('Нажмите получить, перезагрузите новую вкладку через адресную строку.');
								if(goQR == 1) {
									$('button[name="getPicture"]').show();
								}
							};
					</script>
					<p>Обязательно сохраните свой секретный ключ: <b><?=$answer[0]['2fa_key'];?></b></p>
				</div>
				<h2>Завершите подключение:</h2>
				<form action="" method="post">
					<div class="two_flex">
						<p style="color: red;"><?=$error;?></p>
						<input name="2fa_code" class="preInput" placeholder="Введите код из приложения Google Authenticator">
						<button type="submit" class="button" name="submit_2fa">Подключить</button>
					</div>
				</form>
			</div>
		</aside>
<?php include_once "footer.php"; ?>
<?php else: ?>
	<script>setTimeout( 'location="https://evionrp.ru/evi-admin/index.php";', 10 );</script>
<?php endif; ?>