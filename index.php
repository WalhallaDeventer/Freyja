<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

 require_once 'Freyja/Freyja.php';
//require_once 'C:\CloudStation\Walhalla\Intranet\netbeans\Freyja\Freyja.php';
/*require_once './Freyja/Event.php';
require_once './Freyja/Finances.php';
require_once './Freyja/Schedule.php';
require_once './Freyja/Volunteer.php';
require_once './Freyja/Template.php';*/

//$freyja = new Freyja();
$template = new Template();
//$pageTitle = 'Testtmep';

?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead('Home'); ?>
  </head>
  <body>
    <main>
	  <header><?php $template->getHeader(); ?></header>
	  <nav>
<?php $template->getMenu(); ?>
	  </nav>
	  <section>
            <article>
              <h1>Nieuw intranet</h1>
              <p>Hai en welkom op de betaversie van Freyja. De naam is wat random, maar ik kon oprecht niks beters verzinnen. Suggesties zijn niet welkom. Verder kan je contact opnemen met <a href="mailto:kees@walhalla-deventer.nl">kees@walhalla-deventer.nl</a></p>
            </article>
	  </section>
	  <footer><?php $template->getFooter() ?></footer>
	</main>
  </body>
</html>