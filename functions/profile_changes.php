<?php
	require_once "user.php";
	if($_POST['oldEmail']) {
		$oldEmail = $_POST['oldEmail'];
		$emailCode = mt_rand(10000, 99999);
		require "database.php";
		$query = $db->prepare('INSERT INTO `evi_admin`.`email_codes` (`id`, `code`) VALUES (null, :code)');
		$query->bindParam(':code', $emailCode);
		$query->execute();
		$subject = 'Код изменения Email';
		$subject = "=?utf-8?B?".base64_encode($subject)."?=";
		$from = 'erwin@evionrp.ru';
		$headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
		$to = $oldEmail;
		$message = 'Ваш код: '.$emailCode;
		$db = null;
		echo mail($to, $subject, $message, $headers);
	}
	elseif($_POST['newEmail']) {
		$code = $_POST['code'];
		$newEmail = $_POST['newEmail'];
		$user = $_POST['user'];
		require "database.php";
		$query = $db->prepare('SELECT `code` FROM `evi_admin`.`email_codes` WHERE `code` = :code');
		$query->bindParam(':code', $code);
		$query->execute();
		$answer = $query->fetchAll();
		if($answer[0]['code'] == $code) {
			$query = $db->prepare('DELETE FROM `evi_admin`.`email_codes` WHERE `code` = :code');
			$query->bindParam(':code', $code);
			$query->execute();
			User::emailChange($newEmail, $user);
			echo true;
		}
		else
			echo false;
		$db = null;
	}
	elseif($_POST['oldPassword']) {
		$oldPassword = $_POST['oldPassword'];
		require "database.php";
		$query = $db->prepare('SELECT `password` FROM `evi_admin`.`users` WHERE `login` = :login');
		$query->bindParam(':login', $_POST['user']);
		$query->execute();
		$answer = $query->fetchAll();
		if(password_verify($oldPassword, $answer[0]['password']) == true)
			echo true;
		else
			echo false;
		$db = null;
	}
	elseif($_POST['email']) {
		$passwordCode = mt_rand(10000, 99999);
		require "database.php";
		$query = $db->prepare('INSERT INTO `evi_admin`.`pass_codes` (`id`, `code`) VALUES (null, :code)');
		$query->bindParam(':code', $passwordCode);
		$query->execute();
		$subject = 'Код изменения пароля';
		$subject = "=?utf-8?B?".base64_encode($subject)."?=";
		$from = 'erwin@evionrp.ru';
		$to = $_POST['email'];
		$headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
		$message = 'Ваш код: '.$passwordCode;
		$db = null;
		echo mail($to, $subject, $message, $headers);
	}
	elseif($_POST['newPassword']) {
		$code = $_POST['code'];
		$newPassword = $_POST['newPassword'];
		$user = $_POST['user'];
		require "database.php";
		$query = $db->prepare('SELECT `code` FROM `evi_admin`.`pass_codes` WHERE `code` = :code');
		$query->bindParam(':code', $code);
		$query->execute();
		$answer = $query->fetchAll();
		if($answer[0]['code'] == $code) {
			$query = $db->prepare('DELETE FROM `evi_admin`.`pass_codes` WHERE `code` = :code');
			$query->bindParam(':code', $code);
			$query->execute();
			User::passwordChange($newPassword, $user);
			echo true;
		}
		else
			echo false;
		$db = null;
	}
?>