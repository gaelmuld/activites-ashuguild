<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News_model extends CI_Model

function Connect($nom_db,$host='localhost',$user='root',$mdp='',$port=''){
       return $connexion = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$nom_db,$user,$mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
}

function Get($nom_db,$table,$fields=array("*")){
    $DB=Connect($nom_db);
    $fields = implode(",",$fields);
    $sql='SELECT '.$fields.' FROM '.$table;
    $query=$DB->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function Set($nom_db,$table,$array){
    $DB=Connect($nom_db);
    if (array_key_exists ( 0 , $array )){
        $array=SetArray_DB($nom_db,$table,$array);
    }
    $keys= implode(", ",array_keys($array));
    $values="'" . implode("','",$array) . "'";
    $sql='INSERT INTO '.$table.' ('.$keys.') VALUES ('.$values.');';
    $query=$DB->exec($sql);
    
    return true;
}

function SetArray_DB($nom_db,$table,$array){
    $DB=Connect($nom_db);
    $sql='SHOW columns FROM '.$table;
    $query=$DB->query($sql);
    $result=$query->fetchAll();
    $associate=array();
    var_dump($associate);
    for($i=1;$i<count($result);$i++){
        $associate[$result[$i][0]]= $array[$i-1];
        
    }
    return $associate;
    
}



        ?> ?>
