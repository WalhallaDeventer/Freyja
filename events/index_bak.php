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
if($event != null) {
    $details = $event->getDetails();
    ?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead('Overzicht - ' . $details['name'] . ' - Evenementen'); echo PHP_EOL; ?>
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
                  <li id="current"><a href="/events/<?php echo $details['url']; ?>/">Overzicht</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/sales/">Baropmaak</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/cash/">Kas</a></li>
              </ul>
            <img style="max-height: 150px; max-width: 400px; float: right; border: solid black .5px" src="<?php //echo $event->getFBBanner(); ?>" />
            <div id="general">
                Wat een super geinig evenement is dit, zeg.<br /><br/>
                
                <b>Algemeen</b><br/>
                - Naam evenement en locatie<br />
                - Datum en tijden<br/>
                - Organisator intern + contactinfo<br />
                - Organisator extern + contactinfo<br/>
                -                
            </div>
            <div id="timeline">
              <?php echo nl2br("19:00	Techniek en barpersoneel aanwezig
	Ook externe organisatie aanwezig voor versieren en opzetten apparatuur
19:30	Soundcheck dj's
20:00	Deuren open
21:00	Muziek?
00:30	Laatste ronde bar
00:45	Bar dicht
01:00	Walhalla gesloten voor bezoekers => iedereen buiten"); ?>

            </div>
            <div>
              <h2>Draaiboek</h2>
              <p>
                <h3>Concept</h3>
                Het wordt een alternatief Vlierfeest. Het officiële schoolfeest was in november. Door veranderingen binnen het beleid van Het Vlier is het schoolfeest alcoholvrij geworden. Veel 18+'ers vinden dat vrij kut. Ook is er vraag naar een alternatief schoolfeest met een wat chillere sfeer en alternatieve muziek.
              </p>
              <p>
                <h3>Afspraken</h3>
                <?php echo nl2br("Er worden bands/DJ's geregeld door de externe organisatie. Deze worden betaald uit de entreegelden, die voor de externe organisatie zijn. De consumptieomzet is voor Walhalla. De promotie wordt ook extern geregeld, evenals de kaartverkoop.

De audio- en lichttechniek wordt door Walhalla verzorgd. Eventuele extra apparatuur zal kunnen worden gehuurd. Hierover kan nog gesproken worden.
"); ?>
              </p>
            </div>
	  </section>
	  <footer><?php $template->getFooter(); ?></footer>
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
        <?php
        $events = Event::getEvents($freyja->mysqli);
        if($events == null) {
            echo "Geen events gevonden!<br />";
        }
        else {
        ?>
        <table style="font-family: monospace; margin: 2px;">
          <tr style="font-weight: bold;"><td></td><td>Naam</td><td></td><td>Datum</td><td>Begintijd</td><td>Eindtijd</td><td>Facebook</td></tr>
<?php 
              $num = 0;
              
              foreach($events as $i) {
                  printf('          <tr%8$s><td></td><td><a href="/events/%1$s/">%2$s</a></td><td>%7$s</td><td>%3$s</td><td>%4$s</td><td>%5$s</td><td><a href="http://facebook.com/events/%6$s/">%6$s</a></td></tr>' . PHP_EOL,
                          $i['url'],
                          $i['name'],
                          date('d-m', strtotime($i['startTime'])),
                          date('H:i', strtotime($i['startTime'])),
                          date('H:i', strtotime($i['endTime'])),
                          $i['fbEventID'],
                          date('D', strtotime($i['startTime'])),
                          $num % 2 == 0 ? ' style="background-color: #DDDDEE; border: 10px #DDDDEE"' : '');
                  $num++;
              } ?>
        </table> <?php } ?>
      </section>
      <footer><?php $template->getFooter() ?></footer>
    </main>
  </body>
</html>
<?php } ?>