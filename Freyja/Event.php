<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author Kvank
 */
class Event {
    private $mysqli, $idEvent, $details;
    public function __construct($idEvent) {
        global $mysqli;
        $this->idEvent = $idEvent;
        $this->mysqli = $mysqli;
        $this->details = $this->getDetails();
    }
    public function getDetails() {
        $sql = 'SELECT idEvent, name, description, fbEventID, date, startTime, endTime, url FROM events WHERE idEvent=' . $this->idEvent;
        $result = $this->mysqli->query($sql);
        if($result == false)
                return 'null';
        return $result->fetch_assoc();
    }
    
    public function getName() { return $this->details['name']; }
    public function getDescription() { return $this->details['description'];}
    public function getfbEventID() { return $this->details['fbEventID'];}
    public function getStartTime() { return $this->details['startTime'];}
    public function getEndTime() { return $this->details['endTime'];}
    public function getUrl() { return $this->details['url'];}
    public function getFBBanner() {
        try {
          // Returns a `Facebook\FacebookResponse` object
          //echo '[' . $freyja->getAccessToken() . ']';
            global $freyja;
          $response = $freyja->fb->get('/'. $this->getDetails()['fbEventID'] .'?fields=cover', $freyja->FBGetAccessToken()); //https://graph.facebook.com/oauth/access_token?client_id=1143320739069883&client_secret=345017ec1ef935f0afbf91f27d13903d&grant_type=client_credentials
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        } 

        $headerURL = $response->getGraphObject()['cover']['source'];
        return $headerURL;
    }
    
    public function setName() {}
    public function setDescription($content) {
        //Plaatjes moeten eruit en worden opgeslagen want anders is de sql-string veel te groot
        $dom = new DOMDocument();
        $dom->loadHTML($content);

        foreach ($dom->getElementsByTagName('img') as $img) { //http://php.net/manual/en/class.domelement.php
            $src = $img->getAttribute('src');
            if(strpos($src, 'data:') !== false) {
                $imgData = $src;
                $file = $this->base64_to_jpeg($imgData, './uploadedImages/' . time() . strval(rand()) . '.jpeg');
                $img->setAttribute('src', '.' . $file);
            }
        }
        
        $content = $dom->saveHTML();
        $editedDescription = $content;
        $sql = sprintf("UPDATE events SET description = '%s' WHERE events.idEvent = %d", $this->mysqli->real_escape_string($editedDescription), $this->idEvent);
        //$sql = sprintf("UPDATE events SET description = '%s' WHERE events.idEvent = %d", $description, $this->idEvent);
        $result = $this->mysqli->query($sql);
        if($result == false) {
            echo $this->mysqli->error;
            return false;
        }
        return true;
    }
    private function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "w"); 

        $data = explode(',', $base64_string);

        fwrite($ifp, base64_decode($data[1])); 
        fclose($ifp); 

        return $output_file; 
    }
    public function setfbEventID() {}
    public function setStartTime() {}
    public function setEndTime() {}
    
    //baropmaak/entree/munten
    public function saleGetProducts() { //als er geen producten gevonden worden, dan wordt de standaardlijst geladen door een druk op de knop
        //geeft een array met producten en hoeveel er van elk product aan het
        //begin was, aangevuld is en aan het eind was
        /*$products = ['KOELING' => ['GROLSCH', 'HERTOG JAN'],
            'KOELKAST' => ['Coca Cola' => ['begin', 'aangevuld', 'eind'],
                'Coca Cola Light',
                'Fanta Orange'],
            'KASTEN' => ['Lay\'s Naturel',
                'Lay\'s Paprika'],
            'VRIEZER' => ['Broodje Bapao',
                'Tosti']];*/
        $products = ['KOELING' => ['GROLSCH', 'HERTOG JAN'],
            'KOELKAST' => ['Coca Cola',
                'Coca Cola Light',
                'Fanta Orange'],
            'KASTEN' => ['Lay\'s Naturel',
                'Lay\'s Paprika'],
            'VRIEZER' => ['Broodje Bapao',
                'Tosti']];
        //$sql = 'SELECT idEvent, name, description, fbEventID, date, startTime, endTime, url FROM events WHERE idEvent=' . $this->idEvent;
        $sql = 'SELECT idProduct, name, category, price FROM products WHERE active = 1';
        $result = $this->mysqli->query($sql);
        if($result == false)
                return 'null';
        print_r($result->fetch_all(MYSQLI_ASSOC));
        //$products = $result->fetch_assoc();
        return $products;
    }
    public function saleAddedSupply($idProduct, $amount) {}
    public function saleSetStartCount($idProduct, $amount, $counter, $checker) {}
    public function saleSetEndCount($idProduct, $amount, $counter, $checker) {}
    public function saleSetTokens($amount, $counter, $checker) {}
    public function saleSetTickets($amount) {}
    public function saleAddTickets() {} //kolom ticketsSales++
    
    //kas
    public function cashSetStartCount($fivehundred, $twohundred, $hundred,
            $fifty, $twenty, $ten, $five, $two, $one, $fiftyct, $twentyct,
            $tenct, $fivect, $twoct, $onect, $counter, $checker) {}
    public function cashSetEndCount($fivehundred, $twohundred, $hundred,
            $fifty, $twenty, $ten, $five, $two, $one, $fiftyct, $twentyct,
            $tenct, $fivect, $twoct, $onect, $counter, $checker) {}
    public function cashAddSkim($fivehundred, $twohundred, $hundred,
            $fifty, $twenty, $ten, $five, $two, $one, $fiftyct, $twentyct,
            $tenct, $fivect, $twoct, $onect, $counter, $checker) {}
    public function cashAddChange($fivehundred, $twohundred, $hundred,
            $fifty, $twenty, $ten, $five, $two, $one, $fiftyct, $twentyct,
            $tenct, $fivect, $twoct, $onect, $counter) {}
    public function cashSetTokens($amount, $counter, $checker) {}
    
    //static functions to get general info and create new events
    public static function getEvents($mysqli) {
        $sql = 'SELECT idEvent, name, description, fbEventID, startTime, endTime, url FROM events';
        $result = $mysqli->query($sql);
        if($result == false)
                return null;
        return $result->fetch_all(MYSQL_ASSOC);
    }
    public static function getEventsUpcoming($mysqli) {
        $sql = 'SELECT idEvent, name, description, fbEventID, startTime, endTime, url FROM events WHERE endTime >= CURDATE()';
        $result = $mysqli->query($sql);
        if($result == false)
                return null;
        return $result->fetch_all(MYSQL_ASSOC);
    }
    public static function getEventsPrevious($mysqli) {
        $sql = 'SELECT idEvent, name, description, fbEventID, startTime, endTime, url FROM events WHERE endTime < CURDATE()';
        $result = $mysqli->query($sql);
        if($result == false)
                return null;
        return $result->fetch_all(MYSQL_ASSOC);
    }
    public static function createNewEvent($name, $description, $mysqli) {}
    public static function getEventByUrl($url, $mysqli) {
        $sql = sprintf('SELECT idEvent FROM events WHERE url=\'%s\'', $mysqli->real_escape_string($url));
        //echo $sql;
        $result = $mysqli->query($sql);
        if($result == false)
                return null;
        if($result->num_rows == 0)
            return null;
        return new Event($result->fetch_assoc()['idEvent']);
    }
    public static function eventExists($id, $mysqli) {
        $sql = sprintf('SELECT idEvent FROM events WHERE idEvent=%d', $id);
        $result = $mysqli->query($sql);
        if($result == false)
                return false;
        if($result->num_rows == 0)
            return false;
        return true;
    }
}
