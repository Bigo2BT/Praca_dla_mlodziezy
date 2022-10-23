<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}
	$OK = true;
	
	if(isset($_POST['usluga']))
	{
		$usluga = $_POST['usluga'];
		if((strlen($usluga)<1) OR strlen($usluga)>45)
		{
			$OK = false;
			$_SESSION['e_usluga'] = "Pole usługa musi być wypełnione i nie może być dłuższe niż 45 znaków.";
		}
		
		
		$praca = $_POST['praca'];
		if(($praca > '300') OR (!$praca) OR ($praca < 5))
		{
			$OK = false;
			$_SESSION['e_praca'] = "Czas pracy musi być podany nie może zajmować więcej niż 300 minut (5 godzin).";
		}
		
		
		$cena = $_POST['cena'];
		if($cena < 5)
		{
			$OK = false;
			$_SESSION['e_cena'] = "Cena nie może być mniejsza od 5zł.";
		}
		
		
		
		require_once 'connect.php';
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno > 0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				if($OK)
				{
					$id = $_SESSION['id_konto'];
					$data = date('Y-m-d h:i:s');
					
					
					if($polaczenie->query("INSERT INTO zgloszenie (id_konto, dostepnosc, usluga, cz_trwania, cena, cz_wydania) VALUES ($id, $OK, '$usluga', '$praca', $cena, '$data');")) 
					{
						header('Location: index_zalogowany.php');
					}
					else
					{
						throw new Exception(mysqli_connect_errno());
					}
					
				}
		
				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie.</p>';
			//echo $e;
		}
	}
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Dodawanie zgłoszenia </title>
<link href="css/zgloszenia.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Kontener strony -->
<div class="container_reg"> 
  <!-- Nagłówek -->
  <header>
    <a href="index_zalogowany.php">
      <h4 class="logo">Praca dla młodzieży</h4>
    </a>
  </header>
	
	<!-- Główna strona -->
	<main>
		<form method="post" class="logowanie">
            Nazwa zgłoszenia: <br>
            <input name="usluga" type="text" size="60" <?= isset($_POST['usluga']) ? 'value="'.$_POST['usluga'].'"' : ''?> <br><br><br>
			<?php
			if(isset($_SESSION['e_usluga']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_usluga'].'</p>';
				unset($_SESSION['e_usluga']);
			}
			?>
            Czas trwania: (max. 300 minut) <br>
            <input name="praca" type="number" step="5" size="60" <?= isset($_POST['praca']) ? 'value="'.$_POST['praca'].'"' : ''?>><br><br>
			<?php
			if(isset($_SESSION['e_praca']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_praca'].'</p>';
				unset($_SESSION['e_praca']);
			}
			?>
            Cena zgłoszenia: <br>
            <input name="cena"type="number" size="60" <?= isset($_POST['cena']) ? 'value="'.$_POST['cena'].'"' : ''?>> zł<br><br>
			<?php
			if(isset($_SESSION['e_cena']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_cena'].'</p>';
				unset($_SESSION['e_cena']);
			}
			?><br>
            <input type="submit" value="Dodaj zgłoszenie" class="przycisk"> <br><br>
        </form>        
	</main>
	
  <!-- Stopka -->
	<footer>
    	<p class="copyright">
			COPYRIGHT &copy;  2022 - <span class="copyright"> ZSE Opole 2BT </span>
		</p>
	</footer>
</div>
<!-- Koniec dokumentu -->
</body>
</html>