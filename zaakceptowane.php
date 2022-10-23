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
		<h2 style="text-align: center;"> Zaakceptowane przez ciebie zgłoszenia </h2>
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
		$mail = $_SESSION['nick'];
		if($rezultat = $polaczenie->query("SELECT zgloszenie.*,konto.email AS 'email' FROM zgloszenie INNER JOIN konto ON zgloszenie.id_konto = konto.id_konto WHERE zgloszenie.mail_accept = '$mail' ORDER BY zgloszenie.cz_wydania ASC;"))
		{
			while($wiersz = mysqli_fetch_assoc($rezultat))
			{
				$cena = $wiersz['cena'];
				$praca = date('H.i',strtotime($wiersz['cz_trwania']));
				$usluga = $wiersz['usluga'];
				$data = date("d/m/Y", strtotime($wiersz['cz_wydania']));
				$id_zgloszenia = $wiersz['id_zgloszenia'];
				$mail = $wiersz['email'];
				

				echo<<<END
				
				<div style="text-align: center;"> 
					<h2> $usluga,  Data dodania: $data </h2>
					<p> $cena zł / $praca h </p>
					<p> zgłoszenie osoby $mail </p>
				</div>
				
END;
			}
			$rezultat->close();
		}
		$polaczenie->close();
	}
	catch(Exception $e)
	{
		echo '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o logowanie w innym terminie.</p>';
		//echo $e;
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