<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Prace młodzieżowe </title>
<link href="css/index.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- Kontener strony -->
<div class="container"> 
  <!-- Nagłówek -->
  <header> <a href="#">
    <h4 class="logo">Praca dla młodzieży</h4>
    </a>
    <nav>
      <ul>
        <li> Cześć <?= $_SESSION['name'] ?> </li>
		<li> <a href="moje_zgloszenia.php"> Moje  </a> </li>
        <li> <a href="zaakceptowane.php"> Zaakceptowane  </a> </li>
        <li><a href="logout.php"> Wyloguj się </a></li>
      </ul>
    </nav>
  </header>
	
	<!-- Główna strona -->
	<main>
		<table class="zgloszenia">
			<tr>
				<td>
					<a class="dodaj_zgl" href="zgloszenia.php">
      					<div class="dodaj_zgl">
							<h3> Dodaj zgłoszenie </h3>
      						<img src="images/add-icon.png" alt="dodaj" class="ikony"/>
						</div>
					</a>	
				</td>
				<td>
					<a class="szukaj_zgl" href="szuk_zgloszenia.php">
						<div class="szukaj_zgl">
							<h3>Szukaj zgłoszenia</h3>
      						<img src="images/search-icon.png" alt="szukaj" class="ikony"/>
						</div>
					</a>
				</td>
			</tr>
		</table>
		
		<hr>
		
		<section class="info">
			<h2 class="info">
				Strona ta ma pomóc szybciej znaleźć młodym ludziom sposób na zarobek &lt;3
			</h2>
			<h2 class="info">
				Na tej stronie możesz: 
			</h2>
			
			<br><br><br>
			
			<table class="info">
				<tr>
					<td>
						<div class="info">
							<img src="images/profit-icon.jpg" />  <br>
							<span class="info">
								Zdobyć doświadczenie <br> w wybranym  przez siebie zadaniu
							</span>
						</div>
					</td>
					
					<td>
						<div class="info">
							<img src="images/hands.jpg" /> <br>
							<span class="info">
								Poznać nowe osoby, <br> co może doprowadzić do nowej przyjaźni
							</span>
						</div>
					</td>
					
					<td>
						<div class="info">
							<img src="images/money.jpg" /> <br>
							<span class="info">
								Zarobić niemałe pieniądze, <br> a nawet znaleźć swoje miejsce pracy
							</span>
						</div>
					</td>
				</tr>
			</table>
		</section>
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