<?php

/* 
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

//require_once '../Freyja/Freyja.php';
//$mysqli = $freyja->getMysqli();
$file = fopen("log.txt", 'a');
if(isset($_GET['name'])) {
    $string = $_GET['event'] . '\t' . $_GET['name'] . '\t' . $_GET['value'] . "\n\r";
    fwrite($file, $string);
    fclose($file);
    $file = fopen("log.txt", 'r');
}
echo nl2br(fread($file,filesize("log.txt")));
?>