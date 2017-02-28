<?php

/*
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

/**
 * Description of Template
 *
 * @author Kvank
 */
class Template {
    public function getHead($title) {
        $head = '<meta charset="UTF-8" />' . PHP_EOL;
        $head .= '    <title>' . $title . ' - Freyja/Stichting Walhalla</title>' . PHP_EOL;
        $head .= '    <link rel="shortcut icon" type="image/png" href="/freyjanetbeans/favicon.ico" />' . PHP_EOL;
        $head .= '    <link rel="stylesheet" href="/freyjanetbeans/css/styles.css" type="text/css" />' . PHP_EOL;
        $head .= '    <link rel="stylesheet" href="/freyjanetbeans/css/menu.css" type="text/css" />' . PHP_EOL;
        echo $head;
    }
    public function getHeader() {
        echo '<a href="/" title="Home"><img src="/freyjanetbeans/images/walhalla-logo.png" title="Stichting Walhalla" alt="Logo Walhalla" /></a>';
    }
    public function getMenu() {
        include_once __DIR__ . '/menu.php';
    }
    public function getVolunteerMenuById($idVolunteer) {
        $teams = Volunteer($idVolunteer).getTeams();
    }
    public function getVolunteerMenu($volunteer) {
        $teams = $volunteer->getTeams();
    }
    public function getFooter() {
        global $time;
        echo '2017 &copy; Stichting Walhalla (laadtijd: ' . strval(microtime(true)-$time) . ' ms)';
    }
}
