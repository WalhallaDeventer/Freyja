<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

require_once '../Freyja/Freyja.php';
setlocale(LC_ALL, '');
setlocale(LC_ALL, 'nld_nld');
setlocale(LC_ALL, 'nl_NL');
//setlocale(LC_TIME, 'sr_BA');
//$freyja = new Freyja();
$mysqli = $freyja->getMysqli();
$template = new Template();
$pageTitle = 'Testtmep';

?>

<?php
//if((isset($_GET['event']) && is_numeric($_GET['event']) || isset($_GET['eventurl']))) {
//    if(isset($_GET['eventurl'])) {
//        $event = Event::getEventByUrl($_GET['eventurl'], $mysqli);
//        //echo $mysqli->real_escape_string($_GET['eventurl']);
//        if($event == null)
//            $event = new Event($_GET['event']);
//    }
//    else
//        $event = new Event($_GET['event']);
$event = null;
if(isset($_GET['eventurl'])) {
    $event = Event::getEventByUrl($_GET['eventurl'], $mysqli);
}
elseif(isset($_GET['event']) && is_numeric($_GET['event'])) {
    if(Event::eventExists($_GET['event'], $mysqli))
        $event = new Event($_GET['event']);
}
if($event == null) {
    header('Refresh: 0; url=/events/');
    exit();
}
    
$details = $event->getDetails(); ?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead('Kas - ' . $details['name'] . ' - Evenementen'); echo PHP_EOL; ?>
    <link rel="stylesheet" href="/freyjanetbeans/css/events.css" type="text/css" />
  </head>
  <body>
    <main>
	  <header><?php $template->getHeader(); ?></header>
	  <nav>
<?php $template->getMenu(); ?>
	  </nav>
	  <section>
            <!--<a href="/events/">Terug</a><br />
	   <?php print_r($details); ?>-->
              <ul id="eventBar">
                  <li id="title"><?php echo $details['name']; ?></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/">Overzicht</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/sales/">Baropmaak</a></li>
                  <li id="current"><a href="/events/<?php echo $details['url']; ?>/cash/">Kas</a></li>
              </ul>
            <p>
                Wat een super geinig evenement is dit, zeg.
            </p>
	  </section>
	  <footer><?php $template->getFooter(); ?></footer>
	</main>
  </body>
</html>