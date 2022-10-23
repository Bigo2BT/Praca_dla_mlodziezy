<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
	header('Location: logowanie.php');
	exit();
}
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Zaakceptowane zgłoszenia </title>
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
		<h2 style="text-align: center;"> Twoje zgłoszenia </h2>
	<hr>
<?php
					
require_once "connect.php";

try
{
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	if($polaczenie->connect_errno)
	{
		throw new Exception (mysqli_connect_errno());
	}
	
	$id = $_SESSION['id_konto'];
	
	if($rezultat = $polaczenie->query("SELECT * FROM zgloszenie WHERE id_konto = $id ORDER BY dostepnosc DESC, cz_wydania DESC;"))
	{
		while($wiersz = mysqli_fetch_assoc($rezultat))
		{
			$cena = $wiersz['cena'];
			$praca = $wiersz['cz_trwania'];
			$usluga = $wiersz['usluga'];
			$dostepnosc = 'do zrobienia';
			$data = date("d/m/Y", strtotime($wiersz['cz_wydania']));
			$id_zgloszenia = $wiersz['id_zgloszenia'];
			
			if($wiersz['dostepnosc']==0) 
			{
				$dostepnosc = 'Zaakceptował '.$wiersz['mail_accept'];
			}

			echo<<<END
			
			<div style="text-align: center;"> 
				<h2> Nazwa: $usluga,  Data dodania: $data </h2>
				<p> $cena zł / $praca min </p>
				<p> $dostepnosc </p>
				<form action="usun.php" method="POST" >	
					<input type="hidden" name="id_zgloszenia" value="$id_zgloszenia"/>
					<input type="submit" value="usuń zgłoszenie"/>	
				</form>
			</div>
			
			END;
		}
	}
	$polaczenie->close();
}
catch(Exception $e)
{
	echo '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o logowanie w innym terminie.</p>';
}

?>
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