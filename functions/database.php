<?php
	define ('DBUSER', 'root');
	define ('DBPASS', 'WPs{jzaxfZNfaA5#Lf1GSNbphqrZ$x');

	$db = new PDO('mysql:host = localhost; dbname = evi_admin', DBUSER, DBPASS);
	$db->query("SET NAMES utf8");
	# $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	# Enabling error logging mode: , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
?>