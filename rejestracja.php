<?php
	session_start();
	
	if((isset($_SESSION['zalgowany'])) AND ($_SESSION['zalogowany']==true))		//jeżeli jesteś zalogowany to to kieruje na strone zalogowaną
	{
		header('Location: index_zalogowany.php');
		exit();
	}
	if(isset($_POST['email']))
	{		
		$OK = true;
		
		$szukaj = htmlentities($szukaj, ENT_QUOTES, "UTF-8");
		
		$imie = htmlentities($_POST['imie'], ENT_QUOTES, "UTF-8");
		$nazwisko = htmlentities($_POST['nazwisko'], ENT_QUOTES, "UTF-8");
		
		if(strlen($imie)<1)
		{
			$OK = false;
			$_SESSION['e_imie'] = "Pole imie musi być wypełnione";
		}
		
		if(strlen($nazwisko)<1)
		{
			$OK = false;
			$_SESSION['e_nazwisko'] = "Pole nazwisko musi być wypełnione.";
		}
		
		$email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) OR ($emailB != $email))
		{
			$OK = false;
			$_SESSION['e_email'] = "Pole adres e-mail musi być poprawnie wypełnione.";
		}
		
		$haslo1 = htmlentities($_POST['haslo1'], ENT_QUOTES, "UTF-8");
		$haslo2 = htmlentities($_POST['haslo2'], ENT_QUOTES, "UTF-8");
		
		if((strlen($haslo1)<4) OR (strlen($haslo1)>20))
		{
			$OK = false;
			$_SESSION['e_haslo'] = "Pole hasło nie może zawierać mniej niż 4 znaki i więcej niż 31 znaki.";
		}
		
		if($haslo1 != $haslo2)
		{
			$OK = false;
			$_SESSION['e_haslo2'] = "Hasła są różne.";
		}
		
		require_once 'connect.php';
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id_konto FROM konto WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				if(($rezultat->num_rows) > 0)
				{
					$OK = false;
					$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail.";
				}
					
				if($OK)
				{
					$haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);
					
					if($polaczenie->query("INSERT INTO konto VALUES (NULL, '$imie', '$nazwisko', '$email', '$haslo_hash');"))
					{
						header('Location: logowanie.php');
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
			$erro = '<p style="color: red">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie.</p>';
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
<title> Rejestracja </title>
<link href="css/rejestracja.css" rel="stylesheet" type="text/css">
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
		<form method="post" class="logowanie">
			<?= isset($erro) ? $erro : ''?>
            Imię: <br>
            <input type="text" name="imie" size="60"  <?= isset($imie) ? 'value = "'.$imie.'"': '' ?>> <br><br>
			<?php
			if(isset($_SESSION['e_imie']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_imie'].'</p>';
				unset($_SESSION['e_imie']);
			}
			?>
            Nazwisko: <br>
            <input type="text" name="nazwisko" size="60" <?= isset($nazwisko) ? 'value = "'.$nazwisko.'"': '' ?>><br><br>
			<?php
			if(isset($_SESSION['e_nazwisko']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_nazwisko'].'</p>';
				unset($_SESSION['e_nazwisko']);
			}
			?>
            Email: <br>
            <input type="text" name="email" size="60" <?= isset($email) ? 'value = "'.$email.'"': '' ?>><br><br>
			<?php
			if(isset($_SESSION['e_email']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_email'].'</p>';
				unset($_SESSION['e_email']);
			}
			?>
            Hasło: <br>
            <input type="password" name="haslo1" size="60" <?= isset($haslo1) ? 'value = "'.$haslo1.'"': '' ?>><br><br>
			<?php
			if(isset($_SESSION['e_haslo']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_haslo'].'</p>';
				unset($_SESSION['e_haslo']);
			}
			if(isset($_SESSION['e_haslo2']))
			{
				echo '<p style="color: red";>'.$_SESSION['e_haslo2'].'</p>';
				unset($_SESSION['e_haslo2']);
			}
			?>
            Potwierdź hasło: <br>
            <input type="password" name="haslo2" size="60" <?= isset($haslo2) ? 'value = "'.$haslo2.'"': '' ?>><br><br>
            <input type="submit" class="przycisk" value="Zarejestruj się">  <br><br>
            <a href="logowanie.php" class="powrot"> Masz już konto? Zaloguj się </a>
        </form>        
	</main>
	
		<br><br><br><br><br><br>

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
	
	session_unset();