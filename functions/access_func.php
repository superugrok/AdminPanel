<?php
	require "database.php";

	if($_POST['codeId']) {
		$id = $_POST['codeId'];
		$remove = $db->prepare('DELETE FROM `evi_admin`.`codes` WHERE `id` = :id');
		$remove->bindParam(':id', $id);
		$remove->execute();
		echo true;
	}
	elseif($_POST['adminId']) {
		$id = $_POST['adminId'];
		$remove = $db->prepare('DELETE FROM `evi_admin`.`users` WHERE `id` = :id');
		$remove->bindParam(':id', $id);
		$remove->execute();
		echo true;
	}
	elseif($_POST['adminPromoteId']) {
		$id = $_POST['adminPromoteId'];
		$rang = 'Руководитель';
		$promote = $db->prepare('UPDATE `evi_admin`.`users` SET `rang` = :rang WHERE `id` = :id');
		$promote->bindParam(':rang', $rang);
		$promote->bindParam(':id', $id);
		$promote->execute();
		echo true;
	}
	elseif($_POST['adminDemoteId']) {
		$id = $_POST['adminDemoteId'];
		$rang = 'Администратор';
		$demote = $db->prepare('UPDATE `evi_admin`.`users` SET `rang` = :rang WHERE `id` = :id');
		$demote->bindParam(':rang', $rang);
		$demote->bindParam(':id', $id);
		$demote->execute();
		echo true;
	}
	$db = null;
?>