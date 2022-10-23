<?php
session_start();
if(!(isset($_SESSION['zalogowany'])))
{
	header('Location: logowanie.php');
	exit();
}
	
if(isset($_POST['szukaj']))
{
	$szukaj = $_POST['szukaj'];
}
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Wyszukiwarka zgłoszeń </title>
<link href="css/szuk_zgloszenia.css" rel="stylesheet" type="text/css">
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
            <input type="text" name="szukaj" size="60" <?= isset($szukaj) ? 'value = "'.$szukaj.'"': '' ?>><br><br>
            <input type="submit" value="Szukaj zgłoszenia" class="przycisk"> <br><br>
        </form>   
		
	<hr>
	
<?php

try
{
	require_once "connect.php";
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	if($polaczenie->connect_errno)
	{
		throw new Exception (mysqli_connect_errno());
	}
	
	$id = $_SESSION['id_konto'];
	if($szukaj = $_POST['szukaj'])
	{
		
		$szukaj = htmlentities($szukaj, ENT_QUOTES, "UTF-8");
		if($rezultat = $polaczenie->query("SELECT * FROM zgloszenie WHERE dostepnosc = 1 AND id_konto != $id AND usluga LIKE '%$szukaj%' ORDER BY cz_wydania ASC;"))
		{
			while($wiersz = mysqli_fetch_assoc($rezultat))
			{
				$cena = $wiersz['cena'];
				$praca = $wiersz['cz_trwania'];
				$usluga = $wiersz['usluga'];
				$data = date("d/m/Y", strtotime($wiersz['cz_wydania']));
				$id_zgloszenia = $wiersz['id_zgloszenia'];
					
				echo<<<END
				
				<div style="text-align: center;"> 
					<h2> Nazwa: $usluga,  Data dodania: $data </h2>
					<p> $cena zł / $praca min </p>
					<form action="akceptuj.php" method="POST" >	
						<input type="hidden" name="id_zgloszenia" value="$id_zgloszenia"/>
						<input type="submit" value="zaakceptuj zgłoszenie"/>	
					</form>
				</div>
				
END;
			}
			$rezultat->close();
		}
		else
		{
			throw new Exception (mysqli_connect_errno());
		}
		$polaczenie->close();
	}
	else
	{
		if($rezultat = $polaczenie->query("SELECT * FROM zgloszenie WHERE dostepnosc = 1 AND id_konto != $id ORDER BY cz_wydania ASC;"))
		{
			while($wiersz = mysqli_fetch_assoc($rezultat))
			{
				$cena = $wiersz['cena'];
				$praca = $wiersz['cz_trwania'];
				$usluga = $wiersz['usluga'];
				$data = date("d/m/Y", strtotime($wiersz['cz_wydania']));
				$id_zgloszenia = $wiersz['id_zgloszenia'];
					
				echo<<<END
				
				<div style="text-align: center;"> 
					<h2>  $usluga,  Data dodania: $data </h2>
					<p> $cena zł / $praca min </p>
					<form action="akceptuj.php" method="POST" >	
						<input type="hidden" name="id_zgloszenia" value="$id_zgloszenia"/>
						<input type="submit" value="zaakceptuj zgłoszenie"/>	
					</form>
				</div>
				
END;
			}
			$rezultat->close();
		}
		else
		{
			throw new Exception (mysqli_connect_errno());
		}
		$polaczenie->close();
	}
}
catch(Exception $e)	{
	echo '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o logowanie w innym terminie.</p>';
	echo $e;
}
	
?>	
	</main>

	<br><br>
	

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