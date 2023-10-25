<?php
	function checkLenLogin($string) {
		if(strlen($string) <= 15 && strlen($string) >= 3)
			return true;
		else
			return false;
	}
	function checkLenPass($string) {
		if(strlen($string) <= 20 && strlen($string) >= 6)
			return true;
		else
			return false;
	}
	function checkLenEmail($string) {
		if(strlen($string) <= 30 && strlen($string) >= 4 && filter_var($string, FILTER_VALIDATE_EMAIL) == true)
			return true;
		else
			return false;
	}
	function checkExist($login, $email, $code) {
		require "database.php";
		$checkReg = $db->prepare('SELECT `login` FROM `evi_admin`.`users` WHERE `login` = :login');
		$checkReg->bindParam(':login', $login);
		$checkReg->execute();
		$checkResult = $checkReg->fetchAll();
		$checkEmail = $db->prepare('SELECT `email` FROM `evi_admin`.`users` WHERE `email` = :email');
		$checkEmail->bindParam(':email', $email);
		$checkEmail->execute();
		$checkEmailResult = $checkEmail->fetchAll();
		$checkCode = $db->prepare('SELECT `code` FROM `evi_admin`.`codes` WHERE `code` = :code');
		$checkCode->bindParam(':code', $code);
		$checkCode->execute();
		$checkCodeResult = $checkCode->fetchAll();
		$checkCode = NULL;
		$checkReg = NULL;
		$checkEmail = NULL;
		$db = NULL;
		if($checkResult != NULL || strcasecmp($checkResult[0]['login'], $login) == 0 || $checkEmailResult != NULL || $checkCodeResult == NULL)
			return false;
		else
			return true;
	}
	function checkAuth($session) {
		$currentIp = md5($_SERVER['REMOTE_ADDR']);
		$currentAgent = md5($_SERVER['HTTP_USER_AGENT']);
		if($session['userAgent'] == $currentAgent && $session['userIp'] == $currentIp) {
			require "database.php";
			$login = $session['login'];
			$query = $db->prepare('SELECT * FROM `evi_admin`.`users` WHERE `login` = :login');
			$query->bindParam(':login', $login);
			$query->execute();
			$answer = $query->fetchAll();
			$_SESSION['user']['rang'] = $answer[0]['rang'];
			$db = null;
			if($answer[0]['login'] == null) {
				session_destroy();
				setcookie('user', 1, time() + 0, "/");
				return false;
			}
			return true;
		}
		elseif(isset($_COOKIE['user'])) {
			require "database.php";
			$user = unserialize($_COOKIE['user']);
			$login = $user['login'];
			$email = $user['email'];
			$rang = $user['rang'];
			$regDate = $user['regDate'];
			$cookieAgent = $user['userAgent'];
			$cookieIp = $user['userIp'];
			$lastLogin = $user['lastLogin'];
			$query = $db->prepare('SELECT * FROM `evi_admin`.`cookies` WHERE `login` = :login');
			$query->bindParam(':login', $login);
			$query->execute();
			$answer = $query->fetchAll();
			$db = NULL;
			if($login == $answer[0]['login'] && $email == $answer[0]['email'] && $rang == $answer[0]['rang'] && $regDate == $answer[0]['reg_date'] && $cookieAgent == $answer[0]['user_agent'] && $cookieIp == $answer[0]['user_ip']) {
				$rememberAuth = new User($login, $email, $rang, $regDate, $lastLogin);
				$rememberAuth->login(false);
				return true;
			}
		}
		else {
			session_destroy();
			return false;
		}
	}
?>