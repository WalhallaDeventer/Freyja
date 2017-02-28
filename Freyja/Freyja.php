<?php

/*
 * Here comes the text of your license
 * Each line should be prefixed with  * 
 */

/**
 * Description of Freyja
 *
 * @author Kvank
 */
//define('__ROOT__', 'C:\CloudStation\Walhalla\Intranet\netbeans');
$freyja = new Freyja();
$freyja->checkSession();
print_r($_GET);

$time = microtime(true);

global $freyja;
class Freyja {
    private $settings;
    public $mysqli, $fb;
    
    public function __construct() {
        $this->settings = $this->loadSettings();
        $this->dbConnect();
        
        require_once __DIR__ . '/Event.php';
        require_once __DIR__ . '/Finances.php';
        require_once __DIR__ . '/Schedule.php';
        require_once __DIR__ . '/Volunteer.php';
        require_once __DIR__ . '/Template.php';
        
        $this->FBConnect();
        //$this->checkSession();
        //require_once()
    }
    
    public function checkSession() {
        session_start();
        if(!isset($_SESSION['idVolunteer'])) {
            /*if(isset($_POST['username']) && isset($_POST['password'])) {
               if(Volunteer::login($_POST['username'], $_POST['password'])) {
                   return;
               }
               require_once __DIR__ . '/../errorpages/login.php?failed';
            }*/
            global $freyja;
            require_once __DIR__ . '/../errorpages/login.php';
            exit();
        }
        if(isset($_GET['logout']))
            $this->logout();
            
    }
    public function login($username, $password) {
        $sql = sprintf("SELECT * FROM volunteers WHERE nickname = '%s'", $username);
        $result = $this->mysqli->query($sql);
        if($result == false)
                return false;
        if($result->num_rows != 1)
                return false;
        $userArray = $result->fetch_assoc();
        if(!password_verify($password, $userArray['passhash']))
                return false;
        $this->setSession($userArray);
        $result->close();
        return true;
    }
    public function logout() {
            session_destroy();
            header('Refresh: 0; url=/');
    }
    private function setSession($userArray) {
            foreach(array_keys($userArray) as $i) {
                    $_SESSION[$i] = $userArray[$i];
            }
            //$_SESSION['teams'] = $this->getTeamsByVolunteer($userArray['idVolunteer']);
            $_SESSION['last_refresh'] = time();
    }
    private function sessionSet() {
            if(!isset($_SESSION['idVolunteer']))
                    return false;
            if($_SESSION['idVolunteer'] == null)
                    return false;
            if($_SESSION['last_refresh'] > time() + 12 * 60 * 60) {//als laatste update langer dan 12 uur geleden is, logout
                    session_destroy();
                    return false;
            }
            $_SESSION['last_refresh'] = time();
            return true;
    }
    private function loadSettings() {
        return parse_ini_file(__DIR__ . '/freyja.ini', true);
    }
    private function dbConnect() {
        $mysqli = new mysqli($this->settings['mysql_database']['host'],
                $this->settings['mysql_database']['username'],
                $this->settings['mysql_database']['password'],
                $this->settings['mysql_database']['database']);
        if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                                . $mysqli->connect_error);
        }
        $this->mysqli = $mysqli;
    }
    public function getMysqli() {
        return $this->mysqli;
    }
    private function FBConnect() {
        require_once __DIR__ . '/../php-graph-sdk-5.0.0/src/Facebook/autoload.php';
        $this->fb = new Facebook\Facebook([
          'app_id' => $this->settings['fb_api']['api_id'],
          'app_secret' => $this->settings['fb_api']['api_secret'],
          'default_graph_version' => 'v2.8',
        ]);
    }
    public function FBGetAccessToken() {
        return $this->settings['fb_api']['page_access_token'];
    }
}
