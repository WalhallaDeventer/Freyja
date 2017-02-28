<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

require_once '../Freyja/Freyja.php';

//$freyja = new Freyja();
$mysqli = $freyja->getMysqli();
$template = new Template();
$pageTitle = 'Testtmep';

?>

<?php
if(isset($_GET['idEvent'])) {
    $event = new Event($_GET['idEvent']);
    ?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead($event->getDetails()['name'] . ' - Evenementen'); ?>
  </head>
  <body>
    <main>
	  <header><?php $template->getHeader(); ?></header>
	  <nav>
<?php $template->getMenu(); ?>
	  </nav>
	  <section>
	   <?php print_r($event->getDetails()); ?>
              <ul>
                  <li style="display: inline-block;">Overzicht</li>
                  <li style="display: inline-block;">Baropmaak</li>
                  <li style="display: inline-block;">Kas</li>
              </ul>
	  </section>
	  <footer><?php $template->getFooter() ?></footer>
	</main>
  </body>
</html>
<?php
}
else { ?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead('Evenementen'); ?>
  </head>
  <body>
    <main>
	  <header><?php $template->getHeader(); ?></header>
	  <nav>
<?php $template->getMenu(); ?>
	  </nav>
	  <section>
	   sdfsdfdssdfsdf
	  </section>
	  <footer><?php $template->getFooter() ?></footer>
	</main>
  </body>
</html>
<?php } ?>