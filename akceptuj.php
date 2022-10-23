<?php

	session_start();
	require_once "connect.php";
	
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	$id = $_POST['id_zgloszenia'];
	$mail = $_SESSION['nick'];
	
	$polaczenie->query("UPDATE zgloszenie SET mail_accept = '$mail', dostepnosc = 0 WHERE id_zgloszenia = $id;");
	header('Location: szuk_zgloszenia.php');
	$polaczenie->close();