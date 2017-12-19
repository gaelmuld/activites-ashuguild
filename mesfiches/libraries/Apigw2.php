<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apigw2{

     /**********************************\
     |******clé api pour la guilde******|
     |À modifier par le maitre de guilde|
     \**********************************/
    
    private $apiGuild = '382671EA-AF5F-400B-B226-D598179780E7';
    private $apiImg = 'F6403960-F795-904E-9DBF-15F37C5E93421540901B-2F7E-406F-8A34-5A51C6293A46';
    
    /*********************\
    |**Fonctions privées**|
    \*********************/
    private function apiMaitre(){
        return '?access_token='.$this->apiImg;
    }
    private function resultApi($url){
        return json_decode(@file_get_contents($url),true);
    }
    private function getResult($url){
        try{
            return $result=$this->resultApi($url);
        }
        catch(exception $e){
            return false;
        }
    }
    /***********************\
    |**Fonctions publiques**|
    \***********************/
    
    public function getMembresGuild(){
        $url='https://api.guildwars2.com/v2/guild/'.$this->apiGuilde.'/members'.$this->apiMaitre();
        return $this->getResult($url); 
        
    }
    public function getMembreNamesCaracters($apiKey){
        $url='https://api.guildwars2.com/v2/characters?access_token='.$apiKey;
        return $this->getResult($url); 
        
    }
    public function getMembreNameAccount($apiKey){
        $url='https://api.guildwars2.com/v2/account?access_token='.$apiKey;
       return $this->getResult($url); 
    }
}
