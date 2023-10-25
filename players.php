<?php 
	$page = 'Игроки';
	include_once "header.php";
?>
<?php if(checkAuth($_SESSION['user']) == true): ?>
	<link rel="stylesheet" href="css/players.css">
		<aside class="players">
			<div class="players_block">
				<form action="" method="post" class="players_search">
					<p>Поиск игрока:</p>
					<input name="player_search" class="inputer_search" placeholder="Введите ник">
					<button name="go_search" class="btn_search"></button>
				</form>
				<p>Игровой баланс: <b>500$</b></p>
				<div class="players_flex">
					<input name="player_balance" class="inputer" placeholder="Новый баланс">
					<button name="change_balance" class="btn_ok"></button>
				</div>
				<p>Игровой уровень: <b>12</b></p>
				<div class="players_flex">
					<input name="player_level" class="inputer" placeholder="Новый уровень">
					<button name="change_level" class="btn_ok"></button>
				</div>
				<p>Уровень VIP: <b>3</b></p>
				<div class="players_flex">
					<input name="player_vip" class="inputer" placeholder="Новый VIP lvl">
					<button name="change_vip" class="btn_ok"></button>
				</div>
				<p>Реальный баланс:</p>
				<input name="player_rub" class="inputer" placeholder="5000 руб." disabled>
				<p>Всего внесено:</p>
				<input name="player_rub_total" class="inputer" placeholder="50000 руб." disabled>
			</div>
		</aside>
<?php include_once "footer.php"; ?>
<?php endif; ?>