<?php
// fonction de connexion
class Dbconnect {

    // éléments de connexion
    private $db= [
        "host" => "localhost",
        "dbname" => "ashuguild",
        "user" => "root",
        "pass" => ""
    ];
    // prefixe de l'ensemble des tables
    private $prefix= "";
    
    function connectionDB(){
        // avec ou sans prefix
        try{
            return new PDO('mysql:host='.$this->db['host'].';dbname='.$this->db['dbname'], $this->db['user'], $this->db['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        }catch(Exception $e){
            return false;
        }
    }
    function getPrefix(){
        return $this->prefix;
    }
}
