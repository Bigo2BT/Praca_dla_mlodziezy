<?php
	session_start();
	if((isset($_SESSION['zalogowany'])) AND ($_SESSION['zalogowany']==true))
	{
		header('Location: index_zalogowany.php');
		exit();
	}
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Logowanie </title>
<link href="css/logowanie.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Kontener strony -->
<div class="container_reg"> 
  <!-- Nagłówek -->
  <header>
    <a href="index.php">
      <h4 class="logo">Praca dla młodzieży</h4>
    </a>
  </header>
	
	<!-- Główna strona -->
	<main>
		<form action="zaloguj.php" method="post" class="logowanie">
			<?= isset($_SESSION['serw']) ? $_SESSION['serw'] : ''?>
            Email: <br>
            <input type="text" name="email" size="60" <?= isset($_SESSION['eemail']) ? 'value = "'.$_SESSION['eemail'].'"' : '' ?>><br><br>
            Hasło: <br>
            <input type="password" name="haslo" size="60"><br><br>
            <input type="submit" value="Zaloguj się" class="przycisk">
			<?= isset($_SESSION['blad']) ? $_SESSION['blad'] : '<br/><br/><br/>'	?><br><br>
            <a href="rejestracja.php" class="powrot"> Nie posiadasz konta? Zarejestruj się </a>
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

<?php
	unset($_SESSION['eemail']);
	unset($_SESSION['blad']);
	unset($_SESSION['serw']);