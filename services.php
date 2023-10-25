<?php 
	$page = 'Сервисы';
	include_once "header.php";
?>
<?php if(checkAuth($_SESSION['user']) == true): ?>
	<link rel="stylesheet" href="css/services.css">
	<aside class="services">
		<div class="service_block">
			<h2>Сервис авторизации</h2>
			<p class="status_field">Статус: <span class="status" id="1">Активен</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
		<div class="service_block">
			<h2>Сервис персонажа</h2>
			<p class="status_field">Статус: <span class="status" id="2">Активен</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
		<div class="service_block service_right">
			<h2>Сервис финансов</h2>
			<p class="status_field">Статус: <span class="status" id="3">Активен</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
		<div class="service_block">
			<h2>Сервис недвижимости</h2>
			<p class="status_field">Статус: <span class="status" id="4">Ошибка</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
		<div class="service_block">
			<h2>Сервис статистики</h2>
			<p class="status_field">Статус: <span class="status" id="5">Активен</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
		<div class="service_block service_right" id="last">
			<h2>Сервис контроля</h2>
			<p class="status_field">Статус: <span class="status" id="6">Остановлен</span></p>
			<p>Uptime: <b>30</b> часов</p>
			<button class="btn_small" name="info">Подробнее</button>
		</div>
	</aside>
	<script src="js/services.js"></script>
<?php include_once "footer.php"; ?>
<?php endif; ?>