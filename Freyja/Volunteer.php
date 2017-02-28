<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Kvank
 */
class Volunteer {
    private $idVolunteer, $mode;
    public function __construct($idVolunteer, $mode) {
        $this->idVolunteer = $idVolunteer;
        $this->mode = $mode;
    }
    public function setPassword($password) {
        $sql = sprintf('UPDATE volunteers SET passhash=\'%s\' WHERE idVolunteer=%d', $password, $this->idVolunteer);
        $result = $this->mysqli->query($sql);
        if($result == false)
            return false;
        return true;
    }
    public function getTeams() {
        $sql = sprintf('SELECT idTeam, isChief FROM teammemberships WHERE idVolunteer = %d', $idVolunteer);
        $result = $this->mysqli->query($sql);
        if($result == false)
            return null;
        $teamsArray = $result->fetch_all(MYSQL_ASSOC);
        $teams = array();
        foreach($teamsArray as $i) {
            $teams[$i['idTeam']] = $i['isChief'];
        }
        return $teams;
    }
    
    public static function createNewVolunteer($username, $password, $email) {
        
    }
}
