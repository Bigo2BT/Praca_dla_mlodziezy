<?php

	session_start();
	
	if((!isset($_POST['email'])) OR (!isset($_POST['haslo'])))
	{
		header('Location:login.php');
		exit();
	}
	
	require_once "connect.php";
	//mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno)
		{
			throw new Exception(mysqli_connect_errno());
		}
		
		$email = $_POST['email'];
		$haslo = $_POST['haslo'];
		
		$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		
		if($rezultat = $polaczenie->query(sprintf("SELECT * FROM konto WHERE email='%s';",
		mysqli_real_escape_string($polaczenie,$email))))
		{
			$ile = $rezultat->num_rows;
			if($ile!=1)
			{
				$_SESSION['blad'] = '<p style="color:red;"> Błędny e-mail lub hasło</p>';
				header('Location: logowanie.php'); //Tutaj zmień lokalizacje
				$polaczenie->close();
			}
			
			$wiersz = $rezultat->fetch_assoc();
			
			if(password_verify($haslo, $wiersz['haslo']))
			{
				$_SESSION['zalogowany'] = true; 
				$_SESSION['id_konto'] = $wiersz['id_konto'];
				$_SESSION['nick'] = $wiersz['email'];
				$_SESSION['name'] = $wiersz['imie'];
				unset($_SESSION['blad']);
				$rezultat->close();
				header('Location: index_zalogowany.php');  //Tutaj zmień lokalizacje
			}
			else
			{
				$_SESSION['eemail'] = $_POST['email'];
			
				$_SESSION['blad'] = '<p style="color:red;"> Błędny e-mail lub hasło</p>';
				header('Location: logowanie.php'); //Tutaj zmień lokalizacje
			}
		$polaczenie->close();
		}
	}
	catch(Exception $e)
	{
		$_SESSION['serw'] = '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o logowanie w innym terminie.</p>';
		echo $e;
		header('Location: logowanie.php');
	}