<?php
class M_dachis extends CI_Model {

    
    public function __construct()
    {
            parent::__construct();
    }
    function getRank($id){
        return $this->db->query("SELECT * FROM rangs WHERE id = ".$id)->result_array()[0];
    }
    
    function getDachis(){
        
        return $this->db->query('SELECT dachis.id,dachis.pseudo,dachis.compte,dachis.rangId,rangs.niveau FROM dachis INNER JOIN rangs ON rangId=rangs.id ORDER BY rangs.niveau DESC , dachis.compte ASC')->result_array();
        
    }
    
    function getUnderRanks($niveau){
        return $this->db->query("SELECT nom,id FROM rangs WHERE niveau < ".$niveau." AND id>1 ORDER BY niveau ASC")->result_array();
    }
    
    public function getParticipationCount(){
        return $this->db->query('SELECT dachis.id,participants.participant as participe, count(participants.participant) as nbParticipe FROM dachis  LEFT JOIN participants ON dachis.id = id_dachi GROUP BY dachis.id,participe HAVING nbParticipe > 0')->result_array();
    }
    
    public function getCreationCount(){
        return $this->db->query('SELECT dachis.id,COUNT(activites.createur) as nbCreation FROM dachis INNER JOIN rangs ON rangId=rangs.id LEFT JOIN activites ON dachis.id = activites.createur GROUP BY dachis.id ORDER BY dachis.compte')->result_array();
    }
}
