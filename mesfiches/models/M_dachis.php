<?php
class M_dachis extends CI_Model {

    
    public function __construct()
    {
            parent::__construct();
    }
    function getRank($niveau){
        return $this->db->query("SELECT nom FROM rangs WHERE niveau = ".$niveau)->result_array()[0]['nom'];
        
    }


}
