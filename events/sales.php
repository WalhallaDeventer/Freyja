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
//$pageTitle = 'Testtmep';

?>

<?php
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
    <?php $template->getHead('Verkoop - ' . $details['name'] . ' - Evenementen'); echo PHP_EOL; ?>
    <link rel="stylesheet" href="/freyjanetbeans/css/events.css" type="text/css" />
    <script>
    /*function submitForm() {
        var http = new XMLHttpRequest();
        http.open("POST", "update.php", true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = "product=" + <<get search value>>; // probably use document.getElementById(...).value
        http.send(params);
        http.onload = function() {
            alert(http.responseText);
        };
    }*/
    function updateValue(name, value) {
        //if(value == parseInt(value))
        var xmlhttp = new XMLHttpRequest();
        /*xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };*/
        //alert("/events/updateSalesValue.php?event=<?php $details['idEvent']?>&name=" + name + "&value=" + value);
        xmlhttp.open("GET", "/events/updateSalesValue.php?event=<?php echo $details['idEvent']; ?>&name=" + name + "&value=" + value, true);
        xmlhttp.send();
    }
    </script>
  </head>
  <body>
    <main>
	  <header><?php $template->getHeader(); ?></header>
	  <nav>
<?php $template->getMenu(); ?>
	  </nav>
	  <section>
            <!--<a href="/events/">Terug</a><br -->
<?php //print_r($details); ?>
              <ul id="eventBar">
                  <li id="title"><?php echo $details['name']; ?></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/">Overzicht</a></li>
                  <li id="current"><a href="/events/<?php echo $details['url']; ?>/sales/">Baropmaak</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/cash/">Kas</a></li>
              </ul>
            <!--<p>
                Wat een super geinig evenement is dit, zeg.
            </p>-->
            <div>
              <table> <?php //print_r($event->saleGetProducts()); ?>
<?php foreach($event->saleGetProducts() as $k=>$i) {
    //print_r($i);
    printf('                <tr class="category"><th>%s</th><th>IN</th><th>BEGIN</th><th>AANVULLING</th><th>EIND</th><th>VERKOCHT</th><th>PRIJS</th><th>OMZET</th></tr>'
            . PHP_EOL, $k);
    foreach($i as $j) {
       printf('                <tr><td>%1$s</td><td class="fin">XXX</td><td><input type="text" value="XXX" onChange="updateValue(\'begin_%1$s\', this.value);" id="begin_%1$s" /></td><td><input type="text" value="XXX" /></td><td><input type="text" value="XXX" /></td><td class="fin">XXX</td><td class="fin">XXX<td class="fin">XXX</td></tr>'
               . PHP_EOL, $j); 
    }
}
echo '                <tr class="total"><td colspan="7">TOTAAL</td><td>6.000.000,23</td></tr>' . PHP_EOL;
?>
              </table>
            </div>
	  </section>
	  <footer><?php $template->getFooter(); ?></footer>
	</main>
  </body>
</html>