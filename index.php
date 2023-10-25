<?php 
	$page = 'Главная';
	include_once "header.php";
	$userRegDate = getdate($_SESSION['user']['regDate']);
?>
<?php if(checkAuth($_SESSION['user']) == true): ?>
	<link rel="stylesheet" href="css/index.css">
		<aside class="main">
			<div class="welcome_header">
				<h1 class="welcome_head">Добро пожаловать, <b><?=$_SESSION['user']['login']?></b></h1>
			</div>
			<div class="main_welcome">
				<div class="welcome_right">
					<p>Ваша должность: <b><?=$_SESSION['user']['rang']?></b></p>
					<p>Дата регистрации: <b><?=$userRegDate['mday'].".".$userRegDate['mon'].".".$userRegDate['year'];?></b></p>
					<p>Последний вход: <b><?=$userLastLogin['mday'].".".$userLastLogin['mon'].".".$userLastLogin['year'];?></b> в <b><?=$userLastLogin['hours']?>:<?=$userLastLogin['minutes']?></b></p>
				</div>
			</div>
			<div class="tables">
				<div class="admins">
					<table>
						<thead>
							<th>Игровые администраторы</th>
						</thead>
						<tbody>
							<tr id='1'>
								<td class='first_td' id='1'>Erwin</td>
								<td name='1'>Руководитель</td>
								<td id='1'>27.09.2021</td>
								<td class='remove' id='1'></td>
								<td class='promote' id='1'></td>
								<td class='demote' id='1'></td>
							</tr>
							<tr id='2'>
								<td class='first_td' id='2'>DVS</td>
								<td name='2'>Руководитель</td>
								<td id='2'>27.09.2021</td>
								<td class='remove' id='2'></td>
								<td class='promote' id='2'></td>
								<td class='demote' id='2'></td>
							</tr>
							<tr id='3'>
								<td class='first_td' id='3'>Yookie</td>
								<td name='3'>Руководитель</td>
								<td id='3'>27.09.2021</td>
								<td class='remove' id='3'></td>
								<td class='promote' id='3'></td>
								<td class='demote' id='3'></td>
							</tr>
							<tr id='4'>
								<td class='first_td' id='4'>DrEggman</td>
								<td name='4'>Разработчик</td>
								<td id='4'>27.09.2021</td>
								<td class='remove' id='4'></td>
								<td class='promote' id='4'></td>
								<td class='demote' id='4'></td>
							</tr>
							<tr id='5'>
								<td class='first_td' id='5'>heme3ic</td>
								<td name='5'>Разработчик</td>
								<td id='5'>27.09.2021</td>
								<td class='remove' id='5'></td>
								<td class='promote' id='5'></td>
								<td class='demote' id='5'></td>
							</tr>
							<tr id='6'>
								<td class='first_td' id='6'>IDONTSUDO</td>
								<td name='6'>Разработчик</td>
								<td id='6'>27.09.2021</td>
								<td class='remove' id='6'></td>
								<td class='promote' id='6'></td>
								<td class='demote' id='6'></td>
							</tr>
							<tr id='7'>
								<td class='first_td' id='7'>Ramond Dempsey</td>
								<td name='7'>Администратор</td>
								<td id='7'>27.09.2021</td>
								<td class='remove' id='7'></td>
								<td class='promote' id='7'></td>
								<td class='demote' id='7'></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="statistic_site">
					<h2>Статистика сайта</h2>
					<p>Уникальные посещения: <b>500</b></p>
					<p>Всего посещений: <b>1000</b></p>
					<p>Перешли ко второму шагу: <b>250</b></p>
					<p>Перешли к третьему шагу: <b>220</b></p>
					<p>Выполнили последний шаг: <b>100</b></p>
					<p>Перешли на платные услуги: <b>50</b></p>
					<p>Совершили пополнение: <b>30</b></p>
					<p>Среднее время на сайте: <b>10</b> мин.</p>
					<p class="change_stat_server" onclick="showServerStat();">Статистика сервера -></p>
				</div>
				<div class="statistic_server">
					<h2>Статистика сервера</h2>
					<p>Новые регистрации: <b>500</b></p>
					<p>Входов за день: <b>1000</b></p>
					<p>Используют два перс.: <b>250</b></p>
					<p>В гос. структурах: <b>220</b></p>
					<p>В организациях: <b>100</b></p>
					<p>В группировках: <b>50</b></p>
					<p>Всего валюты в мире: <b>100000000$</b></p>
					<p>Среднее время в игре: <b>3</b> часа</p>
					<p class="change_stat_site" onclick="showSiteStat();">Статистика сайта -></p>
				</div>
			</div>
			<div class="server_online">
				<div class="server_online_progress">
					<p>300/1000</p>
				</div>
			</div>
		</aside>
		<script src="js/index.js"></script>
<?php include_once "footer.php"; ?>
<?php endif; ?>