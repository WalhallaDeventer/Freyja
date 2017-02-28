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
    $permissionToEdit = true;
    if(isset($_POST['contents']) && $permissionToEdit)
        $event->setDescription($_POST['contents']);
    $details = $event->getDetails();
    $content = $details['description'];
    
    if(isset($_GET['edit']) && $permissionToEdit)
       $edit = true;
    else
        $edit = false;
    ?>
<!DOCTYPE html>
<html>
  <head>
    <?php $template->getHead('Overzicht - ' . $details['name'] . ' - Evenementen'); echo PHP_EOL; ?>
    <link rel="stylesheet" href="/freyjanetbeans/css/events.css" type="text/css" />
    <script src="https://cdn.quilljs.com/1.2.0/quill.js"></script>
    <?php /*<script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.6.0/katex.min.js" type="text/javascript"></script>*/ ?>
    <?php /*<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js" type="text/javascript"></script>*/ ?>
    <link href="https://cdn.quilljs.com/1.2.0/quill.snow.css" rel="stylesheet">
    <style>
      .ql-container {
          height: 600px;
      }
    </style>
    
    <script>
    function post() {
        method = "post"; 

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", "./");

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "contents");
        //hiddenField.setAttribute("value", editor.getHTML());
        hiddenField.setAttribute("value", document.getElementById("justHtml").innerHTML);

        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
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
            <!--<a href="/events/">Terug</a><br />
	   <?php print_r($details); ?>-->
              <ul id="eventBar">
                  <li id="title"><?php echo $details['name']; ?></li>
                  <li id="current"><a href="/events/<?php echo $details['url']; ?>/">Overzicht</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/sales/">Baropmaak</a></li>
                  <li><a href="/events/<?php echo $details['url']; ?>/cash/">Kas</a></li>
              </ul>
            <!--<div id="general">-->
            <div>
              <img style="max-height: 150px; max-width: 400px; float: right; border: solid black .5px" src="<?php //echo $event->getFBBanner(); ?>" />
                Wat een super geinig evenement is dit, zeg.<br /><br/>
                
                <b>Algemeen</b><br/>
                - Naam evenement en locatie<br />
                - Datum en tijden<br/>
                - Organisator intern + contactinfo<br />
                - Organisator extern + contactinfo<br/>
                -                
            </div><br />
            <?php if(!$edit)
                echo '<a href="?edit">Bewerken</a>';
            ?>
            <div class="container" style="float: none; height: auto;">
              <div id="quillEditor">
                <?php echo $content; ?>         
              </div>
            </div>
            <?php if($edit) { ?><a href="javascript:post()" onclick="post()">Opslaan</a> <?php } ?>
            <!--<div id="timeline">
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
            </div>-->
            <div id="justHtml" style="display: none;"></div>
	  </section>
	  <footer><?php $template->getFooter(); ?></footer>
	</main>
    <?php if($edit) { ?><script>
        //var toolbarOptions = ['bold', 'italic', 'underline', 'strike'];
        var fonts = ['Impact', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
        var Font = Quill.import('formats/font');
        Font.whitelist = fonts;
        Quill.register(Font, true);
        /*var toolbarOptions = [
          [{ 'font': fonts }, { 'size': [] }],
          [ 'bold', 'italic', 'underline', 'strike' ],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'script': 'super' }, { 'script': 'sub' }],
          [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
          [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
          [ 'direction', { 'align': [] }],
          [ 'link', 'image', 'video' ],
          [ 'clean' ]
        ];*/
        
        var options = {
        placeholder: 'Typ hier de evenementinformatie, welke voor elke vrijwilliger zichtbaar is..',
        theme: 'snow',
        modules: {
            'toolbar': [
              [{ 'font': [] }, { 'size': [] }],
              [ 'bold', 'italic', 'underline', 'strike' ],
              [{ 'color': [] }, { 'background': [] }],
              [{ 'script': 'super' }, { 'script': 'sub' }],
              [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
              [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
              [ 'direction', { 'align': [] }],
              [ 'link', 'image', 'video' ],
              [ 'clean' ]
            ],
          }
        };

      var editor = new Quill('#quillEditor', options);
      //var editor = new Quill('#quillEditor', );
      //var preciousContent = document.getElementById('myPrecious');
      //var justTextContent = document.getElementById('justText');
      var justHtmlContent = document.getElementById('justHtml');
      var justHtml = editor.root.innerHTML;
      justHtmlContent.innerHTML = justHtml;

      editor.on('text-change', function() {
        //document.getElementById('quillEditor').style.height = editor.root.ownerDocument.body.scrollHeight + 'px';
        //var delta = editor.getContents();
        //var text = editor.getText();
        var justHtml = editor.root.innerHTML;
        //preciousContent.innerHTML = JSON.stringify(delta);
        //justTextContent.innerHTML = text;
        justHtmlContent.innerHTML = justHtml;
      });

      // Further Reading:
      //https://quilljs.com/guides/working-with-deltas/
      //https://github.com/quilljs/quill/issues/774
    </script><?php } ?>
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