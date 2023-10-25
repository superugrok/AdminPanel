<?php 
	$page = 'Сервер';
	include_once "header.php";
?>
<?php if(checkAuth($_SESSION['user']) == true): ?>
	<link rel="stylesheet" href="css/server.css">
		<aside class="server">
			<div class="console">
				<p>Вывод истории консоли...</p>
			</div>
			<div class="interract">
				<input type="text" placeholder="Введите команду..." name="command" class="inputer">
				<button name="sendCommand" class="btn_small btn_send">Отправить</button>
				<button name="serverStatus" class="btn_small">Статус</button>
				<button name="serverStart" class="btn_small btn_actions">Старт</button>
				<button name="serverStop" class="btn_small btn_actions">Стоп</button>
				<button name="serverRestart" class="btn_small btn_actions">Рестарт</button>
			</div>
		</aside>
		<script src="js/server.js"></script>
<?php include_once "footer.php"; ?>
<?php endif; ?>