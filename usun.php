<?php

	session_start();
	require_once "connect.php";
	
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	$id = $_POST['id_zgloszenia'];
	
	$polaczenie->query("DELETE FROM zgloszenie WHERE id_zgloszenia = $id;");
	header('Location: moje_zgloszenia.php');
	$polaczenie->close();