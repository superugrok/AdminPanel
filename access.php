<?php 
	$page = 'Управление';
	include_once "header.php";

	if(isset($_POST['generate'])) {
		require "functions/database.php";
		$code = md5(mt_rand(52, 10000));
		$insertCode = $db->prepare('INSERT INTO `evi_admin`.`codes` (`id`, `code`) VALUES (null, :code)');
		$insertCode->bindParam(':code', $code);
		$insertCode->execute();
		$db = null;
	}
	require "functions/database.php";
	# Получение айди существующих кодов
	$getFirstRow = $db->prepare('SELECT `id` FROM `evi_admin`.`codes` ORDER BY `id` ASC LIMIT 1');
	$getFirstRow->execute();
	$firstRow = $getFirstRow->fetchAll();
	$getLastRow = $db->prepare('SELECT `id` FROM `evi_admin`.`codes` ORDER BY `id` DESC LIMIT 1');
	$getLastRow->execute();
	$lastRow = $getLastRow->fetchAll();
	# Получение айди существующих админов
	$getAdminFirstRow = $db->prepare('SELECT `id` FROM `evi_admin`.`users` ORDER BY `id` ASC LIMIT 1');
	$getAdminFirstRow->execute();
	$firstAdminRow = $getAdminFirstRow->fetchAll();
	$getAdminLastRow = $db->prepare('SELECT `id` FROM `evi_admin`.`users` ORDER BY `id` DESC LIMIT 1');
	$getAdminLastRow->execute();
	$lastAdminRow = $getAdminLastRow->fetchAll();
?>
<?php if(checkAuth($_SESSION['user']) == true && $_SESSION['user']['rang'] == 'Руководитель'): ?>
	<link rel="stylesheet" href="css/access.css">
		<aside class="access">
			<div class="codes">
				<table class="codes_table">
					<thead>
						<th>Существующие коды:</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						for ($i = $firstRow[0]['id']; $i <= $lastRow[0]['id']; $i++) {
							$getCodes = $db->prepare('SELECT `code` FROM `evi_admin`.`codes` WHERE `id` = :i');
							$getCodes->bindParam(':i', $i);
							$getCodes->execute();
							$answer = $getCodes->fetchAll();
							$validCode = $answer[0]['code'];
							if($answer)
								echo "<tr id='$i'>"."<td id='$i'>$validCode</td>"."<td class='remove' id='$i' onclick='removeCode(this)'></td>"."</tr>";
						}
						?>
					</tbody>
				</table>
			<form action="" method="post" class="btn_generate">
				<button name="generate" class="btn_small">Генерировать код</button>
			</form>
			</div>
			<div class="adm_list">
				<table class="adm_table">
					<thead>
						<th>Список администраторов:</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</thead>
					<tbody>
						<?php
						for ($i = $firstAdminRow[0]['id']; $i <= $lastAdminRow[0]['id']; $i++) {
							$getCodes = $db->prepare('SELECT * FROM `evi_admin`.`users` WHERE `id` = :i');
							$getCodes->bindParam(':i', $i);
							$getCodes->execute();
							$answer = $getCodes->fetchAll();
							$admin = $answer[0]['login'];
							$rang = $answer[0]['rang'];
							if($answer)
								echo "<tr id='$i'>"."<td class='adm_td' id='$i'>$admin</td>"."<td class='adm_td' name='$i'>$rang</td>"."<td class='remove' id='$i' onclick='removeAdmin(this)'></td>"."<td class='promote' id='$i' onclick='promoteAdmin(this)'></td>"."<td class='demote' id='$i' onclick='demoteAdmin(this)'></td>"."</tr>";
						}
						$db = null;
						?>
					</tbody>
				</table>
			</div>
			<div class="donate_info">
				<table class="donate_table">
					<thead>
						<th>Период / Сумма</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>За год</td>
							<td>1.000.000$</td>
						</tr>
						<tr>
							<td>За месяц</td>
							<td>100.000$</td>
						</tr>
						<tr>
							<td>Сегодня</td>
							<td>100$</td>
						</tr>
						<tr>
							<td>Последний</td>
							<td>10$</td>
						</tr>
					</tbody>
				</table>
			</div>
		</aside>
		<script src="js/access.js"></script>
<?php include_once "footer.php"; ?>
<?php else: ?>
	<p style="color: red; font-size: 2rem;">Доступ запрещён!</p>
		<script>
			setTimeout( 'location="https://evionrp.ru/evi-admin/index.php";', 1 );
		</script>
<?php endif; ?>