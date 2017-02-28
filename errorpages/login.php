<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */
//$freyja = new Freyja();
$loginFailed = false;
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
	$usernameRegex = "^[a-zA-Z]{2,25}$^";
	if(preg_match($usernameRegex, $_POST['username']))
		$loginFailed = !$freyja->login($_POST['username'], $_POST['password']);
	else {
		$loginFailed = true;
	}
	if(!$loginFailed) {
                header("Refresh:0");
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Login - Freyja/Stichting Walhalla</title>
    <link rel="stylesheet" href="/css/landing.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans|Questrial" rel="stylesheet">
  </head>
  <body id="landing">
    <main>
	  <header><img src="/images/walhalla-logo.png" title="Stichting Walhalla" alt="Logo Walhalla" /></header>
	  <section>
	    <form action="" method="post">
		<?php echo ($loginFailed) ? '  <span id="error">Foutieve inloggegevens</span>' . PHP_EOL : '' ?>  <input name="username" size="25" maxlength="50" type="text" placeholder="Gebruikersnaam" /><br />
		  <input name="password" size="25" maxlength="50" type="password" placeholder="Wachtwoord" /><br />
		  <input name="submit" value="Aanmelden" type="submit" />
		</form>
          </section>
	  <footer>Freyja (bèta 1) 2017 &copy; Stichting Walhalla</footer>
	</main>
  </body>
</html>