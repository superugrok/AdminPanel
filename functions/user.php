<?php
	class User {
		public $login;
		public $email;
		public $rang;
		public $regDate;
		public $lastLogin;

		public function __construct($login, $email, $rang, $regDate, $lastLogin) {
			$this->login = $login;
			$this->email = $email;
			$this->rang = $rang;
			$this->regDate = $regDate;
			$this->lastLogin = $lastLogin;
		}
		public function register($login, $password, $email, $code, $rang, $autoLogin) {
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
			if($checkResult != NULL || $checkEmailResult != NULL || $checkCodeResult == NULL) {
				return;
			}
			else {
				$reg = $db->prepare('INSERT INTO `evi_admin`.`users` (`id`, `login`, `email`, `password`, `rang`, `reg_date`, `current_login`, `last_login`, `avatar`) VALUES (NULL, :login, :email, :password, :rang, :regDate, :currentLogin, :lastLogin, :avatar)');
				$reg->bindParam(':login', $login);
				$reg->bindParam(':email', $email);
				$reg->bindParam(':password', $password);
				$reg->bindParam(':rang', $rang);
				$reg->bindParam(':regDate', time());
				$reg->bindParam(':currentLogin', time());
				$reg->bindParam(':lastLogin', time());
				$avatar = 'https://evionrp.ru/evi-admin/assets/avatars/default.png';
				$reg->bindParam(':avatar', $avatar);
				$reg->execute();
				$reg = $db->prepare('DELETE FROM `evi_admin`.`codes` WHERE `code` = :code');
				$reg->bindParam(':code', $code);
				$reg->execute();
				$reg = NULL;
				if($autoLogin == true) {
					$user = new User($login, $email, $rang, time(), time());
					$user->login(false);
				}
			}
			$db = NULL;
		}
		public function login($remember) {
			$data = array(
				'login' => $this->login, 
				'email' => $this->email, 
				'rang' => $this->rang, 
				'regDate' => $this->regDate, 
				'lastLogin' => $this->lastLogin, 
				'userAgent' => md5($_SERVER['HTTP_USER_AGENT']), 
				'userIp' => md5($_SERVER['REMOTE_ADDR']));
			session_start();
			$_SESSION['user'] = $data;
			require "database.php";
			$currentLogin = $db->prepare('SELECT `current_login` FROM `evi_admin`.`users` WHERE `login` = :login');
			$currentLogin->bindParam(':login', $this->login);
			$currentLogin->execute();
			$currentTime = $currentLogin->fetchAll();
			$insertTime = $db->prepare('UPDATE `evi_admin`.`users` SET `current_login` = :curTime WHERE `login` = :login');
			$insertTime->bindParam(':curTime', time());
			$insertTime->bindParam(':login', $this->login);
			$insertTime->execute();
			$insertTime = $db->prepare('UPDATE `evi_admin`.`users` SET `last_login` = :curTime WHERE `login` = :login');
			$insertTime->bindParam(':curTime', $currentTime[0]['current_login']);
			$insertTime->bindParam(':login', $this->login);
			$insertTime->execute();
			$db = NULL;
			if($remember == true) {
				require "database.php";
				$removeOld = $db->prepare('DELETE FROM `evi_admin`.`cookies` WHERE `login` = :login');
				$removeOld->bindParam(':login', $this->login);
				$removeOld->execute();
				$remember = $db->prepare('INSERT INTO `evi_admin`.`cookies` (`login`, `email`, `rang`, `reg_date`, `user_agent`, `user_ip`) VALUES (:login, :email, :rang, :regDate, :userAgent, :userIp)');
				$remember->bindParam(':login', $this->login);
				$remember->bindParam(':email', $this->email);
				$remember->bindParam(':rang', $this->rang);
				$remember->bindParam(':regDate', $this->regDate);
				$remember->bindParam(':userAgent', md5($_SERVER['HTTP_USER_AGENT']));
				$remember->bindParam(':userIp', md5($_SERVER['REMOTE_ADDR']));
				$remember->execute();
				$remember = NULL;
				setcookie('user', serialize($data), time() + 86500, "/");
				$db = NULL;
			}
		}
		public function emailChange($newEmail, $user) {
			require "database.php";
			$email = filter_var(trim($newEmail), FILTER_SANITIZE_STRING);
			$query = $db->prepare('UPDATE `evi_admin`.`users` SET `email` = :newEmail WHERE `login` = :login');
			$query->bindParam(':newEmail', $email);
			$query->bindParam(':login', $user);
			$query->execute();
			session_start();
			$_SESSION['user']['email'] = $email;
			$db = null;
		}
		public function passwordChange($newPassword, $user) {
			require "database.php";
			$password = filter_var(trim(password_hash($newPassword, PASSWORD_DEFAULT)), FILTER_SANITIZE_STRING);
			$query = $db->prepare('UPDATE `evi_admin`.`users` SET `password` = :newPassword WHERE `login` = :login');
			$query->bindParam(':newPassword', $password);
			$query->bindParam(':login', $user);
			$query->execute();
			$db = null;
		}
	}
	class SimpleImage {

 	  var $image;
 	  var $image_type;
	
 	  function load($filename) {
 	     $image_info = getimagesize($filename);
 	     $this->image_type = $image_info[2];
 	     if( $this->image_type == IMAGETYPE_JPEG ) {
 	        $this->image = imagecreatefromjpeg($filename);
 	     } elseif( $this->image_type == IMAGETYPE_GIF ) {
 	        $this->image = imagecreatefromgif($filename);
 	     } elseif( $this->image_type == IMAGETYPE_PNG ) {
 	        $this->image = imagecreatefrompng($filename);
 	     }
 	  }
 	  function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 	     if( $image_type == IMAGETYPE_JPEG ) {
 	        imagejpeg($this->image,$filename,$compression);
 	     } elseif( $image_type == IMAGETYPE_GIF ) {
 	        imagegif($this->image,$filename);
 	     } elseif( $image_type == IMAGETYPE_PNG ) {
 	        imagepng($this->image,$filename);
 	     }
 	     if( $permissions != null) {
 	        chmod($filename,$permissions);
 	     }
 	  }
 	  function output($image_type=IMAGETYPE_JPEG) {
 	     if( $image_type == IMAGETYPE_JPEG ) {
 	        imagejpeg($this->image);
 	     } elseif( $image_type == IMAGETYPE_GIF ) {
 	        imagegif($this->image);
 	     } elseif( $image_type == IMAGETYPE_PNG ) {
 	        imagepng($this->image);
 	     }
 	  }
 	  function getWidth() {
 	     return imagesx($this->image);
 	  }
 	  function getHeight() {
 	     return imagesy($this->image);
 	  }
 	  function resizeToHeight($height) {
 	     $ratio = $height / $this->getHeight();
 	     $width = $this->getWidth() * $ratio;
 	     $this->resize($width,$height);
 	  }
 	  function resizeToWidth($width) {
 	     $ratio = $width / $this->getWidth();
 	     $height = $this->getheight() * $ratio;
 	     $this->resize($width,$height);
 	  }
 	  function scale($scale) {
 	     $width = $this->getWidth() * $scale/100;
 	     $height = $this->getheight() * $scale/100;
 	     $this->resize($width,$height);
 	  }
 	  function resize($width,$height) {
 	     $new_image = imagecreatetruecolor($width, $height);
 	     imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
 	     $this->image = $new_image;
 	  }
	}
?>